# process_prediction.py
import sys
import json
import joblib
import numpy as np

def load_model():
    try:
        model = joblib.load('model/your_trained_model.pkl')
        feature_names = joblib.load('model/feature_names.pkl')
        return model, feature_names
    except Exception as e:
        print(json.dumps({'error': str(e)}))
        sys.exit(1)

def predict(input_data, model, feature_names):
    try:
        # Chuẩn bị mảng features
        features = np.zeros(len(feature_names))
        
        # Ánh xạ dữ liệu đầu vào vào đúng vị trí features
        # ĐIỀU CHỈNH PHẦN NÀY THEO MODEL CỦA BẠN
        mapping = {
            'tenure': 'tenure',
            'monthly_charges': 'MonthlyCharges',
            'total_charges': 'TotalCharges',
            'contract': 'Contract',
            'internet_service': 'InternetService',
            'online_security': 'OnlineSecurity'
        }
        
        for form_field, model_feature in mapping.items():
            if model_feature in feature_names:
                idx = feature_names.index(model_feature)
                features[idx] = input_data.get(form_field, 0)
        
        # Dự đoán
        proba = model.predict_proba([features])[0]
        prediction = model.predict([features])[0]
        
        return {
            'success': True,
            'churn': bool(prediction),
            'probability': float(proba[1]),  # Xác suất lớp churn
            'features': features.tolist()
        }
    except Exception as e:
        return {
            'success': False,
            'error': str(e)
        }

if __name__ == '__main__':
    # Load model một lần khi khởi chạy
    model, feature_names = load_model()
    
    # Nhận dữ liệu từ PHP
    input_json = sys.argv[1]
    input_data = json.loads(input_json)
    
    # Thực hiện dự đoán
    result = predict(input_data, model, feature_names)
    
    # Trả về kết quả dạng JSON
    print(json.dumps(result))