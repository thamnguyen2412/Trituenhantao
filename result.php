<?php
// result.php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: predict.php');
    exit();
}

// Thu thập dữ liệu từ form
$input_data = [
    'customer_id' => $_POST['customer_id'],
    'tenure' => $_POST['tenure'],
    'monthly_charges' => $_POST['monthly_charges'],
    'total_charges' => $_POST['total_charges'],
    'contract' => $_POST['contract'],
    'internet_service' => $_POST['internet_service'],
    'online_security' => $_POST['online_security']
];

// Thực hiện dự đoán
$result = predict_churn($input_data);

if (!$result || isset($result['error'])) {
    die("Có lỗi xảy ra khi dự đoán: " . ($result['error'] ?? 'Lỗi không xác định'));
}

// Lưu log dự đoán
log_prediction(
    $input_data['customer_id'],
    $result['churn'],
    $result['probability'],
    $result['features']
);

$page_title = "Kết quả dự đoán";
include 'includes/header.php';
?>

<div class="container">
    <h1 class="text-center mb-4"><?= $page_title ?></h1>
    
    <div class="card shadow">
        <div class="card-body">
            <div class="alert alert-<?= $result['churn'] ? 'danger' : 'success' ?>">
                <h4 class="alert-heading">
                    <?= $result['churn'] ? 'CẢNH BÁO: Khả năng cao rời bỏ dịch vụ' : 'TỐT: Khả năng thấp rời bỏ dịch vụ' ?>
                </h4>
                <p>Xác suất: <strong><?= round($result['probability'] * 100, 2) ?>%</strong></p>
            </div>
            
            <div class="customer-info mb-4">
                <h5>Thông tin khách hàng</h5>
                <ul>
                    <li>Mã KH: <?= htmlspecialchars($input_data['customer_id']) ?></li>
                    <li>Thời gian sử dụng: <?= $input_data['tenure'] ?> tháng</li>
                    <li>Chi phí hàng tháng: <?= number_format($input_data['monthly_charges'], 0, ',', '.') ?> VND</li>
                </ul>
            </div>
            
            <div class="recommendations">
                <h5>Đề xuất hành động</h5>
                <?php if ($result['churn']): ?>
                    <div class="alert alert-warning">
                        <ul>
                            <li>Ưu đãi giảm giá 10-15% cho gói dịch vụ hiện tại</li>
                            <li>Tặng thêm 1 tháng sử dụng miễn phí</li>
                            <li>Nhân viên liên hệ tư vấn trong 24h</li>
                            <li>Đề xuất nâng cấp gói dịch vụ với ưu đãi đặc biệt</li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p>Khách hàng trung thành. Có thể đề xuất:</p>
                        <ul>
                            <li>Các dịch vụ bổ sung (nếu chưa sử dụng)</li>
                            <li>Gói cao cấp hơn với ưu đãi</li>
                            <li>Chương trình khách hàng thân thiết</li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            
            <a href="predict.php" class="btn btn-primary">Thực hiện dự đoán mới</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>