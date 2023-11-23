<?php
require_once "header.php";
?>
		<main class="content">
				<div class="container-fluid p-0">
					
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                    include $page . '.php';
                    ?>

				</div>
			</main>
		</div>
	</div>
	

  <script src="assets/js/main.js"></script>

</body>
</html>
<?php
require_once "footer.php";
	?>