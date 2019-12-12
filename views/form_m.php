<h1>Upload some files:</h1>
<!-- Make form submit to the current page... NB: always escape REQUEST_URI/PHP_SELF!!! -->

<form enctype="multipart/form-data" action="index.php?page=upload" method="post">
	<div>
		<!-- The "name" value should have the array brackets for simpler processing -->
		<p><label for="fileinput">Upload some files:</label></p>
		<input name="userfile[]" type="file" id="fileinput" />
	</div>
	<div>
		<input name="userfile[]" type="file" />
	</div>
	<div>
		<input name="userfile[]" type="file" />
	</div>
	<div>
		<input name="userfile[]" type="file" />
	</div>
	<div>
		<input name="userfile[]" type="file" />
	</div>
	<p>
		<input type="submit" value="Upload Files" name="multifileupload" />
	</p>
</form>