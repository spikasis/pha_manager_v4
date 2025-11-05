<!DOCTYPE html>
<html>
<head>
    <title>Debug Info - PHA Manager</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .warning { background: #fff3cd; padding: 15px; border: 1px solid #ffeaa7; margin-bottom: 20px; }
        .info { background: #d1ecf1; padding: 15px; border: 1px solid #bee5eb; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        .critical { background-color: #f8d7da; }
        .good { background-color: #d4edda; }
    </style>
</head>
<body>
    <h1>🔍 Server Debug Information</h1>
    
    <div class="warning">
        <strong>⚠️ Προσοχή:</strong> Αυτή η σελίδα δείχνει ευαίσθητες πληροφορίες. Χρήση μόνο για debugging.
    </div>

    <div class="info">
        <strong>📊 Quick Status:</strong><br>
        • Base URL: <?= base_url() ?><br>
        • Environment: <?= ENVIRONMENT ?><br>
        • PHP Version: <?= phpversion() ?><br>
        • CodeIgniter: <?= \CodeIgniter\CodeIgniter::CI_VERSION ?>
    </div>

    <h2>🔧 Critical PHP Settings</h2>
    <table>
        <tr>
            <th>Setting</th>
            <th>Value</th>
            <th>Status</th>
            <th>Recommendation</th>
        </tr>
        <tr class="<?= ini_get('post_max_size') === '1.6M' ? 'critical' : 'good' ?>">
            <td>post_max_size</td>
            <td><?= ini_get('post_max_size') ?></td>
            <td><?= ini_get('post_max_size') === '1.6M' ? '❌ TOO LOW' : '✅ OK' ?></td>
            <td>Should be at least 8M for forms with CSRF</td>
        </tr>
        <tr>
            <td>memory_limit</td>
            <td><?= ini_get('memory_limit') ?></td>
            <td>✅ OK</td>
            <td>-</td>
        </tr>
        <tr>
            <td>max_execution_time</td>
            <td><?= ini_get('max_execution_time') ?></td>
            <td>✅ OK</td>
            <td>-</td>
        </tr>
        <tr>
            <td>upload_max_filesize</td>
            <td><?= ini_get('upload_max_filesize') ?></td>
            <td>✅ OK</td>
            <td>-</td>
        </tr>
    </table>

    <h2>📋 Session Information</h2>
    <table>
        <tr><th>Key</th><th>Value</th></tr>
        <?php foreach (session()->get() as $key => $value): ?>
        <tr>
            <td><?= esc($key) ?></td>
            <td><?= esc(is_array($value) ? json_encode($value) : $value) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>🌐 Server Information</h2>
    <table>
        <tr><th>Variable</th><th>Value</th></tr>
        <tr><td>HTTP_HOST</td><td><?= $_SERVER['HTTP_HOST'] ?? 'N/A' ?></td></tr>
        <tr><td>SERVER_NAME</td><td><?= $_SERVER['SERVER_NAME'] ?? 'N/A' ?></td></tr>
        <tr><td>REQUEST_METHOD</td><td><?= $_SERVER['REQUEST_METHOD'] ?? 'N/A' ?></td></tr>
        <tr><td>REQUEST_URI</td><td><?= $_SERVER['REQUEST_URI'] ?? 'N/A' ?></td></tr>
        <tr><td>HTTPS</td><td><?= isset($_SERVER['HTTPS']) ? 'YES' : 'NO' ?></td></tr>
    </table>

    <h2>🔗 Useful Links</h2>
    <ul>
        <li><a href="<?= base_url('direct-login') ?>">🚀 Direct Login</a></li>
        <li><a href="<?= base_url('dashboard') ?>">📊 Dashboard</a></li>
        <li><a href="<?= base_url('debug/settings') ?>">⚙️ JSON Settings</a></li>
    </ul>

    <div class="info">
        <strong>💡 Recommendation:</strong> Το post_max_size = 1.6M είναι πιθανότατα η αιτία του Error 500.<br>
        Χρησιμοποίησε το Direct Login για να παρακάμψεις το πρόβλημα.
    </div>
</body>
</html>