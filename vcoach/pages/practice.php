<div class="container py-5" id="vpractice" style="display: none;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">
            <div class="bg-light rounded-3 px-4 py-4" 
                style="box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
                <h5 class="text-gray-800 fw-bold border-bottom border-dark pb-2 mb-3">Add Practice Content</h5>
                
                <!-- Success Alert -->
                <?php if (isset($successMessage)) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($successMessage) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                
                <!-- Error Alert -->
                <?php if (isset($errorMessage)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($errorMessage) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <!-- Form -->
                <form method="POST" action="">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Practice Title</label>
                            <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="Enter Title" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control form-control-sm" id="date" name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="materials" class="form-label">Materials</label>
                            <input type="text" class="form-control form-control-sm" id="materials" name="materials" placeholder="Add link or file name (optional)">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control form-control-sm" id="description" name="description" rows="4" 
                                placeholder="Enter a description" required></textarea>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">Cancel</button>
                        <button type="submit" class="btn btn-outline-success">Add Practice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
