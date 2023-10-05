import sys
from ultralytics import YOLO

image_path = sys.argv[1]

# Load the YOLOv8 model
model = YOLO("C:\\xampp\\htdocs\\Graduation Project\\pet-planetY2\\yolov8l.pt")

results = model.predict(image_path)

result = results[0]

box = result.boxes[0]

class_id = result.names[box.cls[0].item()]

print(class_id)
