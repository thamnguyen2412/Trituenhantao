<?php
// predict.php
require_once 'includes/config.php';

$page_title = "Dự đoán khả năng rời bỏ dịch vụ";
include 'includes/header.php';
?>

<div class="container">
    <h1 class="text-center mb-4"><?= $page_title ?></h1>
    
    <div class="card shadow">
        <div class="card-body">
            <form id="predictionForm" action="result.php" method="post">
                <!-- Thông tin cơ bản -->
                <div class="form-group">
                    <label for="customer_id">Mã khách hàng:</label>
                    <input type="text" class="form-control" id="customer_id" name="customer_id" required>
                </div>
                
                <!-- Các trường dữ liệu cần thiết cho model -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tenure">Thời gian sử dụng (tháng):</label>
                            <input type="number" class="form-control" id="tenure" name="tenure" min="0" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="monthly_charges">Chi phí hàng tháng (VND):</label>
                            <input type="number" step="0.01" class="form-control" id="monthly_charges" name="monthly_charges" min="0" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="total_charges">Tổng chi phí (VND):</label>
                            <input type="number" step="0.01" class="form-control" id="total_charges" name="total_charges" min="0" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contract">Loại hợp đồng:</label>
                            <select class="form-control" id="contract" name="contract" required>
                                <option value="0">Hàng tháng</option>
                                <option value="1">1 năm</option>
                                <option value="2">2 năm</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="internet_service">Dịch vụ Internet:</label>
                            <select class="form-control" id="internet_service" name="internet_service" required>
                                <option value="0">Không</option>
                                <option value="1">DSL</option>
                                <option value="2">Cáp quang</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="online_security">Bảo mật trực tuyến:</label>
                            <select class="form-control" id="online_security" name="online_security" required>
                                <option value="0">Không</option>
                                <option value="1">Có</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Dự đoán</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>