<button id="checkAllButton">Check All</button>
    <input type="checkbox" class="checkbox"> Checkbox 1
    <br>
    <input type="checkbox" class="checkbox"> Checkbox 2
    <br>
    <input type="checkbox" class="checkbox"> Checkbox 3
    <br>
    <input type="checkbox" class="checkbox"> Checkbox 4
    <br>
    <input type="checkbox" class="checkbox"> Checkbox 5
    <br>

    <script>
        // Mendapatkan elemen tombol "Check All" dan semua elemen checkbox lainnya
        var checkAllButton = document.getElementById('checkAllButton');
        var checkboxes = document.querySelectorAll('.checkbox');

        // Menambahkan event listener untuk tombol "Check All"
        checkAllButton.addEventListener('click', function () {
            // Toggle status centang semua kotak centang lainnya
            var isChecked = false;
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
                if (checkboxes[i].checked) {
                    isChecked = true;
                }
            }

            // Ubah teks tombol berdasarkan status centang
            if (isChecked) {
                checkAllButton.textContent = 'Uncheck All';
            } else {
                checkAllButton.textContent = 'Check All';
            }
        });
        </script>