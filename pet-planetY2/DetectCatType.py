import tensorflow as tf
import json
import sys
import numpy as np

image_path = sys.argv[1]

# Load the JSON model configuration
model_path = "D:\\Cats Model.json"
with open(model_path, "r") as f:
    model_json = json.load(f)

# Create the model from the JSON configuration
model = tf.keras.models.model_from_json(json.dumps(model_json))

# Preprocess the image

image = tf.keras.preprocessing.image.load_img(image_path, target_size=(256, 256))
image = tf.keras.preprocessing.image.img_to_array(image)
image = np.expand_dims(image, axis=0)
image = image / 255.0  # Normalize the image
# Read and preprocess the image


# Perform image detection
predictions = model.predict(image, verbose=0)

# Define the list of cat types (class labels)
cat_types = [
    "Ragdoll Cat",
    "Siamese Cat",
    "Persian Cat",
    "Mumbai Cat",
    "Abyssinian",
    "American Shorthair",
    "Maine Coon",
]

# Get the predicted class index
predicted_class_index = np.argmax(predictions[0])

# Get the predicted cat type based on the class index
predicted_cat_type = cat_types[predicted_class_index]

# Print the predicted cat type
print(predicted_cat_type)
