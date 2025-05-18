<?php

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
require __DIR__ . '../../../public/assets/vendor/autoload.php';

class PushNotificationService
{
    private $db;
    private string $vapidPublicKey;
    private string $vapidPrivateKey;

    public function __construct($db, string $vapidPublicKey, string $vapidPrivateKey)
    {
        $this->db = $db;
        $this->vapidPublicKey = $vapidPublicKey;
        $this->vapidPrivateKey = $vapidPrivateKey;
    }

    public function sendNotification($usernames, string $title, string $body, string $url): string
    {
        $webPush = new WebPush([
            'VAPID' => [
                'subject' => 'mailto:admin@yourdomain.com',
                'publicKey' => $this->vapidPublicKey,
                'privateKey' => $this->vapidPrivateKey,
            ],
        ]);

        $subscriptions = $this->getSubscriptions($usernames);
        if (empty($subscriptions)) {
            return json_encode(['sent' => 0, 'total_subscriptions' => 0]);
        }

        $count = 0;
        foreach ($subscriptions as $sub) {
            $subscription = Subscription::create([
                'endpoint' => $sub['endpoint'],
                'publicKey' => $sub['public_key'],
                'authToken' => $sub['auth_token'],
                'contentEncoding' => $sub['content_encoding'] ?? 'aes128gcm',
            ]);

            $payload = json_encode([
                'title' => $title,
                'body' => $body,
                'icon' => '/public/assets/icons/icon-192x192.png',
                'url' => $url,
            ]);

            $webPush->queueNotification($subscription, $payload);
            $count++;

            if ($count % 100 === 0) {
                $this->flushReports($webPush);
            }
        }

        $this->flushReports($webPush);

        return json_encode(['sent' => $count, 'total_subscriptions' => $count]);
    }

    public function sendCustomNotifications(array $notifications): string
    {
        $webPush = new WebPush([
            'VAPID' => [
                'subject' => 'mailto:admin@yourdomain.com',
                'publicKey' => $this->vapidPublicKey,
                'privateKey' => $this->vapidPrivateKey,
            ],
        ]);

        $count = 0;
        foreach ($notifications as $notification) {
            $subs = $this->getSubscriptions([$notification['username']]);
            foreach ($subs as $sub) {
                $subscription = Subscription::create([
                    'endpoint' => $sub['endpoint'],
                    'publicKey' => $sub['public_key'],
                    'authToken' => $sub['auth_token'],
                ]);

                $payload = json_encode([
                    'title' => $notification['title'],
                    'body' => $notification['body'],
                    'icon' => '/public/assets/icons/icon-192x192.png',
                    'url' => $notification['url'],
                ]);

                $webPush->queueNotification($subscription, $payload);
                $count++;

                if ($count % 100 === 0) {
                    $this->flushReports($webPush);
                }
            }
        }

        $this->flushReports($webPush);

        return json_encode(['sent' => $count]);
    }

    private function getSubscriptions($usernames): array
    {
        if (!is_array($usernames)) {
            $usernames = [$usernames];
        }

        if (empty($usernames)) {
            $query = "SELECT endpoint, public_key, auth_token FROM push_subscriptions";
            $stmt = $this->db->prepare($query);
        } else {
            $placeholders = implode(',', array_fill(0, count($usernames), '?'));
            $query = "SELECT endpoint, public_key, auth_token FROM push_subscriptions WHERE username IN ($placeholders)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param(str_repeat('s', count($usernames)), ...$usernames);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $subscriptions = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $subscriptions;
    }

    private function flushReports(WebPush $webPush): void
    {
        foreach ($webPush->flush() as $report) {
            if ($report->isSubscriptionExpired()) {
                $endpoint = $this->db->real_escape_string($report->getEndpoint());
                $this->db->query("DELETE FROM push_subscriptions WHERE endpoint = '$endpoint'");
            }
        }
    }
}
