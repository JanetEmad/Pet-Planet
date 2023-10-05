import tensorflow as tf
import json
import sys
import numpy as np
import os

# Set TensorFlow log level to suppress the output
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "3"
tf.get_logger().setLevel("ERROR")


image_path = sys.argv[1]

# Load the JSON model configuration
model_path = "D:\\Dogs Model.json"
with open(model_path, "r") as f:
    model_json = json.load(f)

# Create the model from the JSON configuration
model = tf.keras.models.model_from_json(json.dumps(model_json))

# Preprocess the image

# image_path = "C:\\Users\\3com\\OneDrive\\Desktop\\OIP.jpeg"
image = tf.keras.preprocessing.image.load_img(image_path, target_size=(256, 256))
image = tf.keras.preprocessing.image.img_to_array(image)
image = np.expand_dims(image, axis=0)
image = image / 255.0  # Normalize the image
# Read and preprocess the image


# Perform image detection
predictions = model.predict(image, verbose=0)

# Define the list of dog types (class labels)
dog_types = [
    "Abrador Retriever",
    "Poodle",
    "Bulldog",
    "Husky",
    "Dalmatian",
    "Beagle",
    "German Shepherd",
    "Rottweiler",
]

# Get the predicted class index
predicted_class_index = np.argmin(predictions[0])

# Get the predicted dog type based on the class index
predicted_dog_type = dog_types[predicted_class_index]

print(predicted_dog_type)
