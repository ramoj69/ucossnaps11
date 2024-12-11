<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php  
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
	<style>
		/* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    color: #333;
}

h1, h2, h3, h4, h5, h6 {
    margin: 0;
}

a {
    text-decoration: none;
    color: #007bff;
}

a:hover {
    text-decoration: underline;
}

/* Navbar */
.navbar {
    background-color: #8EB486;
    color: white;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar a {
    color: white;
    font-weight: bold;
    margin-left: 15px;
}

/* Forms */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

form p {
    margin: 0;
}

form label {
    font-weight: bold;
}

form input[type="text"], form input[type="file"] {
    padding: 3px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
}

form input[type="submit"], form button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #997C70;
    color: white;
    cursor: pointer;
    font-weight: bold;
}

form input[type="submit"]:hover, form button:hover {
    background-color: #0056b3;
}

/* Containers */
.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 15px;
}

/* Cards */
.card {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.card img {
    width: 100%;
    height: auto;
    display: block;
}

.card-body {
    padding: 15px;
}

.card-title {
    font-size: 1.25em;
    margin-bottom: 10px;
}

.card-text {
    margin-bottom: 10px;
    color: #666;
}

.card a.btn {
    display: inline-block;
    padding: 8px 15px;
    border-radius: 5px;
    font-size: 0.9em;
    margin-top: 10px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #a71d2a;
}

.btn-warning {
    background-color: #ffc107;
    color: black;
}

.btn-warning:hover {
    background-color: #d39e00;
}

/* Albums and Images */
.albums, .images {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.album, .photoContainer {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    width: 300px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.album h3 {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.photoContainer img {
    max-width: 100%;
    height: auto;
    border-bottom: 1px solid #ddd;
    margin-bottom: 10px;
}

/* Footer */
footer {
    background-color: #007bff;
    color: white;
    text-align: center;
    padding: 10px;
    margin-top: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .albums, .images {
        flex-direction: column;
        align-items: center;
    }

    .album, .photoContainer {
        width: 90%;
    }
}

	</style>
</head>
<body>
	<?php include 'navbar.php'; ?>

	<!-- <div class="insertPhotoForm" style="display: flex; justify-content: center;">
		<form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
			<p>
				<label for="#">Description</label>
				<input type="text" name="photoDescription">
			</p>
			<p>
				<label for="#">Photo Upload</label>
				<input type="file" name="image">
				<input type="submit" name="insertPhotoBtn" style="margin-top: 10px;">
			</p>
		</form>
	</div> -->
	<div class="createAlbumForm" style="display: flex; justify-content: center;">
    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="album_name">Album Name</label>
            <input type="text" name="album_name" required>
            <input type="submit" name="createAlbumBtn" value="Create Album">
        </p>
    </form>
</div>
<?php $albums = getAlbumsByUser($pdo, $_SESSION['user_id']); ?>

<<div class="albums" style="display: flex; flex-wrap: wrap; gap: 15px;">
    <?php foreach ($albums as $album) { ?>
        <div class="album" style="border: 1px solid gray; padding: 10px;">
            <h3><?php echo htmlspecialchars($album['album_name']); ?></h3>
            <a href="viewalbum.php?album_id=<?php echo $album['album_id']; ?>">View Album</a>

            <?php if ($_SESSION['user_id'] == $album['user_id']) { ?>
                <!-- Update Album Name Form -->
                <form action="core/handleForms.php" method="POST" style="margin-top: 5px;">
                    <input type="hidden" name="album_id" value="<?php echo $album['album_id']; ?>">
                    <input type="text" name="new_album_name" value="<?php echo htmlspecialchars($album['album_name']); ?>" required>
                    <input type="submit" name="updateAlbumBtn" value="Update" style="background-color: blue; color: white; border: none; padding: 5px 10px;">
                </form>

                <!-- Delete Album Form -->
                <form action="core/handleForms.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this album? This will delete all the photos inside it as well.')" style="margin-top: 5px;">
                    <input type="hidden" name="album_id" value="<?php echo $album['album_id']; ?>">
                    <input type="submit" name="deleteAlbumBtn" value="Delete Album" style="background-color: red; color: white; border: none; padding: 5px 10px;">
                </form>
            <?php } ?>
        </div>
    <?php } ?>
</div>




	<?php $getAllPhotos = getAllPhotos($pdo); ?>
	<?php foreach ($getAllPhotos as $row) { ?>

	<div class="images" style="display: flex; justify-content: center; margin-top: 25px;">
		<div class="photoContainer" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%;">

			<img src="images/<?php echo $row['photo_name']; ?>" alt="" style="width: 100%;">

			<div class="photoDescription" style="padding:25px;">
				<a href="profile.php?username=<?php echo $row['username']; ?>"><h2><?php echo $row['username']; ?></h2></a>
				<p><i><?php echo $row['date_added']; ?></i></p>
				<h4><?php echo $row['description']; ?></h4>

				<?php if ($_SESSION['username'] == $row['username']) { ?>
					<a href="editphoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Edit </a>
					<br>
					<br>
					<a href="deletephoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Delete</a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
</body>
</html>