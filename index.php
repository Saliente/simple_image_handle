<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .image-container {
            text-align: center;
            width: 23%; /* 4 images per line with some space in between */
            margin-bottom: 20px;
        }
        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            display: block;
            margin: 0 auto 1px;
        }
        <!-- HTML !-->
.button {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 6px 14px;
  font-family: -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif;
  border-radius: 6px;
  border: none;

  color: #fff;
  background: linear-gradient(180deg, #4B91F7 0%, #367AF6 100%);
   background-origin: border-box;
  box-shadow: 0px 0.5px 1.5px rgba(54, 122, 246, 0.25), inset 0px 0.8px 0px -0.25px rgba(255, 255, 255, 0.2);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button:focus {
  box-shadow: inset 0px 0.8px 0px -0.25px rgba(255, 255, 255, 0.2), 0px 0.5px 1.5px rgba(54, 122, 246, 0.25), 0px 0px 0px 3.5px rgba(58, 108, 217, 0.5);
  outline: 0;
}
    </style>
</head>
<body>
    <h1>Image Gallery</h1>
    <div class="upload-form">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required>
            <button type="submit" name="upload" class="upload-button">Upload Image</button>
        </form>
    </div>
    
    <div class="gallery">
        <?php
        $directory = 'images'; // Specify your image directory
        
        // Handle image upload
        if (isset($_POST['upload'])) {
            $target_file = $directory . '/' . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if the file is an image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                } else {
                    // Check file size (optional, limit to 5MB)
                    if ($_FILES["image"]["size"] > 5000000) {
                        echo "Sorry, your file is too large.";
                    } else {
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        } else {
                            // If everything is ok, try to upload the file
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    }
                }
            } else {
                echo "File is not an image.";
            }
        }
        ?>
        </div>
    <div class="gallery">
        <?php
        $directory = 'img'; // Specify your image directory
        $images = glob($directory . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        foreach ($images as $image) {
            $imageName = basename($image);
            echo '<div class="image-container">';
            echo '<p>' . $imageName . '</p>';
            echo '<img src="' . $image . '" class="thumbnail" alt="' . $imageName . '">';
            echo '<a href="' . $image . '" download="' . $imageName . '"><button class="button" role="button">Download</button></a>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>