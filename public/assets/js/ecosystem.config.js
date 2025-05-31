module.exports = {
  apps: [
    
    {
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
  },

    {
        name: "bep-api",
        script: "sendUsdtBep20.js", // Your Express entry file
        instances: 1, // Typically don't cluster Express unless stateless
        exec_mode: "fork",
        env: {
        NODE_ENV: "production",
        PORT: 6000,
        },
        error_file: "logs/api-err.log",
        out_file: "logs/api-out.log",
        watch: false // Disable for production
    }
]
}