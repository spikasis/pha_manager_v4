<?php
/**
 * 🚨 ULTRA-SIMPLE HOTFIX for Corrupted Composer/TCPDF
 * Upload this as: eggyisi_doc_simple_fix.php
 * 
 * Issue: TCPDF config directory corrupted, Composer broken
 * Solution: Immediate redirect to working emergency generator
 */

// Get stock ID from URL
$stock_id = 0;

if (isset($_GET['id'])) {
    $stock_id = intval($_GET['id']);
} else {
    // Try to extract from URI path
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (preg_match('/\/(\d+)(?:\/|$)/', $uri, $matches)) {
        $stock_id = intval($matches[1]);
    }
}

if ($stock_id <= 0) {
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Error</title></head><body>";
    echo "<h1>❌ Invalid Stock ID</h1>";
    echo "<p>Usage: eggyisi_doc_simple_fix.php?id=STOCK_ID</p>";
    echo "<p><a href='javascript:history.back()'>← Go Back</a></p>";
    echo "</body></html>";
    exit;
}

// Log the redirect
error_log("Composer corruption hotfix: redirecting stock ID {$stock_id} to emergency generator");

// Immediate redirect to emergency generator
$emergency_url = "ultimate_emergency_warranty.php?id={$stock_id}";

// Multiple redirect methods for maximum compatibility
if (!headers_sent()) {
    header("Location: {$emergency_url}");
    exit;
} else {
    // Fallback if headers already sent
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Redirecting</title>";
    echo "<meta http-equiv='refresh' content='0;url={$emergency_url}'></head><body>";
    echo "<script>window.location.href = '{$emergency_url}';</script>";
    echo "<h1>🔄 Redirecting to Emergency Warranty Generator...</h1>";
    echo "<p>If not redirected automatically: <a href='{$emergency_url}'>Click Here</a></p>";
    echo "</body></html>";
}
?>