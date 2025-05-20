module.exports = {
  apps: [{
    name: "socket-server",
    script: "socket_io_server.js", // Your main server file
    instances: "max",
    exec_mode: "cluster",
    env: {
      NODE_ENV: "production",
      PORT: 7001,
      REDIS_HOST: "127.0.0.1"
    },
    error_file: "logs/err.log",
    out_file: "logs/out.log",
    merge_logs: true,
    log_date_format: "YYYY-MM-DD HH:mm:ss"
  }]
}