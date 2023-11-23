  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item"><a href="?page=profile&profile=index">Profile</a></li>
          <li class="breadcrumb-item active"><a href="?page=take-kamera">Capture Profile Image</a></li>
        </ol>
      </nav>
    </div>

    <!-- End Page Title -->
    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <!-- <img src="" alt="Profile" class="rounded-circle"> -->
              <canvas id="image-canvas"></canvas>
              <h2><?= $_SESSION['user']['nama_user'] ?></h2>
              <h3><?= $_SESSION['user']['username'] ?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Capture Photo Image</button>
                </li>
              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade profile-edit pt-3 active show" id="profile-edit" role="tabpanel">

                  <!-- Profile Edit Form -->
                  <div class="row mb-3">
                    <div class="col-md-8 col-lg-9">
                      <div id="capture-container">
                        <video width="400px" id="camera-feed" autoplay playsinline></video>
                      </div>
                      <form id="image-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="image-data" name="image-data">
                        <a id="capture-button" class="btn btn-success btn-sm">Take Foto</a>
                        <button type="submit" class="btn btn-primary btn-sm">Submit Image</button>
                      </form>
                      <?php
                      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["image-data"])) {
                        $dbHost = "localhost";
                        $dbUser = "root";
                        $dbPass = "";
                        $dbName = "inventaris_barang";

                        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

                        if ($conn->connect_error) {
                          die("Koneksi database gagal: " . $conn->connect_error);
                        }

                        $base64Data = $_POST['image-data'];
                        $base64Data = explode(',', $base64Data);

                        $imageData = $base64Data[1];

                        $imageData = base64_decode($imageData);

                        $id = $_SESSION['user']['id_user'];
                        $imageName = uniqid() . '.jpg';
                        $sql = "UPDATE user SET foto=(?) WHERE id_user='$id'";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $imageName);

                        $queryfoto = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id' ");
                        $datafoto = mysqli_fetch_array($queryfoto);

                        if (is_file("assets/img/avatars/" . $datafoto['foto']))
                          unlink("assets/img/avatars/" . $datafoto['foto']);

                        if ($stmt->execute()) {
                          $session = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id' ");
                          $_SESSION['user'] = mysqli_fetch_array($session);
                          echo "<script>alert('Data Berhasil Diubah'); location.href='index.php?page=profile&profile=index'</script>";
                        } else {
                          echo "Gagal menyimpan gambar ke database. ERROR" . $stmt->error;
                        }

                        $stmt->close();

                        $imageFolder = 'assets/img/avatars/';
                        $imagePath = $imageFolder . $imageName;

                        if (file_put_contents($imagePath, $imageData)) {
                          echo "<br>Gambar berhasil disimpan ke folder.";
                        } else {
                          echo "<br>Gagal menyimpan gambar ke folder.";
                        }

                        $conn->close();
                      }
                      ?>

                      <script>
                        const cameraFeed = document.getElementById('camera-feed');
                        const captureButton = document.getElementById('capture-button');

                        const imageCanvas = document.getElementById('image-canvas');
                        imageCanvas.style.width = '200px';
                        imageCanvas.style.height = '200px';
                        imageCanvas.style.borderRadius = '50%';
                        const imageForm = document.getElementById('image-canvas');
                        const imageDataInput = document.getElementById('image-data');

                        async function setupCamera() {
                          const stream = await navigator.mediaDevices.getUserMedia({
                            video: true
                          });
                          cameraFeed.srcObject = stream;
                        }

                        captureButton.addEventListener('click', () => {
                          const context = imageCanvas.getContext('2d');
                          imageCanvas.width = cameraFeed.videoWidth;
                          imageCanvas.height = cameraFeed.videoHeight;
                          context.drawImage(cameraFeed, 0, 0, cameraFeed.videoWidth, cameraFeed.videoHeight);
                          const imageData = imageCanvas.toDataURL('image/jpeg');
                          imageDataInput.value = imageData;
                          imageForm.style.display = 'block';
                        });

                        setupCamera();
                      </script>
                    </div>
                  </div>
                </div>
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->