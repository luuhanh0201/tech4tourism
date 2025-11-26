<!-- Render danh sách các loại tour -->
<!-- Code giao diện Dashboard của admin -->
<!-- <h1>Dashboard admin</h1> -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourManager Pro - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        
        <div class="main-content">
            <form id="tourForm" action="" method="POST">
                <h3 class="mb-3">Create New Tour</h3>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên tour</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên tour" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <input type="text" class="form-control" name="description" id="description" placeholder="Nhập mô tả" required>
                </div>

                <div class="mb-3">
                    <input type="hidden" class="form-control" name="created_at" id="created_at" value="<?=date('Y-m-d H:i:s')?>" required>
                </div>

                <div class="mb-3">
                    <input type="hidden" class="form-control" name="updated_at" id="updated_at" value="<?=date('Y-m-d H:i:s')?>" required>
                </div>

                <button type="submit" class="btn btn-success" name="submit">Tạo mới</button>
            </form>

            <script>
                document.getElementById('tourForm').addEventListener('submit', function(event) {
                    const name = document.getElementById('name').value.trim();
                    const description = document.getElementById('description').value.trim();
                    const createdAt = document.getElementById('created_at').value.trim();
                    const updatedAt = document.getElementById('updated_at').value.trim();

                    const timestampRegex = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;

                    if (!name) {
                        alert('Tên tour không được để trống');
                        event.preventDefault();
                        return;
                    }

                    if (!description) {
                        alert('Mô tả không được để trống');
                        event.preventDefault();
                        return;
                    }
                });
            </script>


        </div>
</body>

</html>