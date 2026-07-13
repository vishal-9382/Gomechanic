<div class="container my-5">
    <div class="card card-registration mx-auto border-0">
        <div class="row g-0">
            <!-- Left Side Image -->
            <div class="col-xl-6 d-none d-xl-block" style="background: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.03) 0%, rgba(6, 182, 212, 0.03) 90%); display: flex !important; align-items: center; justify-content: center; padding: 40px;">
                <img src="images/user.png" alt="User Signup" class="img-fluid rounded-4 shadow-sm" style="max-height: 400px; object-fit: contain;" />
            </div>
            
            <!-- Right Side Form -->
            <div class="col-xl-6">
                <div class="card-body p-md-5 text-black">
                    <form method="post" action="">
                        <h3 class="mb-4 text-uppercase fw-bold" style="font-family: 'Outfit', sans-serif; background: linear-gradient(to right, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">User Sign Up</h3>
                        <p class="text-secondary small mb-4">Create your account to start booking mechanics near you</p>

                        <div class="mb-3">
                            <label class="form-label" for="regName">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-user text-secondary"></i></span>
                                <input type="text" id="regName" name="name" class="form-control border-start-0" placeholder="John Doe" required style="border-radius: 0 10px 10px 0 !important;" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="regCnic">Aadhar Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-id-card text-secondary"></i></span>
                                <input type="text" id="regCnic" pattern="[0-9]*" name="cnic" class="form-control border-start-0" placeholder="12-digit Aadhar Number" required style="border-radius: 0 10px 10px 0 !important;" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="regAddress">Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-map-marker-alt text-secondary"></i></span>
                                <input type="text" id="regAddress" name="address" class="form-control border-start-0" placeholder="Street Address, Area" required style="border-radius: 0 10px 10px 0 !important;" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="regCity">City</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-city text-secondary"></i></span>
                                <input type="text" id="regCity" name="city" class="form-control border-start-0" placeholder="City" required style="border-radius: 0 10px 10px 0 !important;" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="regMobile">Mobile Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-phone text-secondary"></i></span>
                                <input type="text" id="regMobile" pattern="[0-9]*" name="mobile" class="form-control border-start-0" placeholder="10-digit Mobile" required style="border-radius: 0 10px 10px 0 !important;" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="regEmail">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-envelope text-secondary"></i></span>
                                <input type="email" id="regEmail" name="email" class="form-control border-start-0" placeholder="name@example.com" required style="border-radius: 0 10px 10px 0 !important;" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="regPassword">Password</label>
                                <div class="input-group password-wrapper">
                                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-lock text-secondary"></i></span>
                                    <input type="password" id="regPassword" name="password" class="form-control border-start-0" placeholder="••••••••" required style="border-radius: 0 10px 10px 0 !important; padding-right: 45px !important;" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="regConfirmPassword">Confirm Password</label>
                                <div class="input-group password-wrapper">
                                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-lock text-secondary"></i></span>
                                    <input type="password" id="regConfirmPassword" name="confirmpassword" class="form-control border-start-0" placeholder="••••••••" required style="border-radius: 0 10px 10px 0 !important; padding-right: 45px !important;" />
                                </div>
                            </div>
                        </div>

                        <button type="submit" value="Sign Up" name="register" class="btn btn-custom w-100 py-3 fw-bold mt-3">
                            <i class="fas fa-user-plus me-2"></i> Register Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>