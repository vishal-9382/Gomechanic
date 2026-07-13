<div class="container my-5">
  <div class="card card-registration mx-auto border-0">
    <div class="row g-0">
      <!-- Left Side Image -->
      <div class="col-xl-6 d-none d-xl-block" style="background: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.03) 0%, rgba(6, 182, 212, 0.03) 90%); display: flex !important; align-items: center; justify-content: center; padding: 40px;">
        <img
          src="https://media.istockphoto.com/id/165818977/vector/mechanic-thumb-up.jpg?b=1&s=612x612&w=0&k=20&c=E8uh0xQWsgs60PbRTK7x-Q7KQzZm9jgAyja69YbhtSg="
          alt="Mechanic Signup" class="img-fluid rounded-4 shadow-sm" style="max-height: 420px; object-fit: contain;" />
      </div>

      <!-- Right Side Form -->
      <div class="col-xl-6">
        <div class="card-body p-md-5 text-black">
          <form method="post" action="" enctype="multipart/form-data">
            <h3 class="mb-4 text-uppercase fw-bold" style="font-family: 'Outfit', sans-serif; background: linear-gradient(to right, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Mechanic Sign Up</h3>
            <p class="text-secondary small mb-4">Register as a service provider to start receiving work requests</p>

            <div class="mb-3">
              <label class="form-label" for="mechName">Full Name</label>
              <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-user text-secondary"></i></span>
                <input type="text" id="mechName" name="name" class="form-control border-start-0" placeholder="Enter Name" required style="border-radius: 0 10px 10px 0 !important;" />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="mechCnic">Aadhar Number</label>
              <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-id-card text-secondary"></i></span>
                <input type="text" id="mechCnic" pattern="[0-9]*" name="cnic" class="form-control border-start-0" placeholder="12-digit Aadhar Number" required style="border-radius: 0 10px 10px 0 !important;" />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="mechAddress">Address</label>
              <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-map-marker-alt text-secondary"></i></span>
                <input type="text" id="mechAddress" name="address" class="form-control border-start-0" placeholder="Address" required style="border-radius: 0 10px 10px 0 !important;" />
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="distt">City</label>
                <div class="input-group">
                  <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-city text-secondary"></i></span>
                  <select id="distt" name="city" class="form-control border-start-0" onchange="loadarea()" required style="border-radius: 0 10px 10px 0 !important;">
                    <option selected disabled value="">Select City</option>
                    <?php
                    $query = "SELECT * FROM cities";
                    $results = mysqli_query($connection, $query);
                    if ($results && mysqli_num_rows($results) > 0) {
                      while ($row = mysqli_fetch_object($results)) {
                        echo "<option value='{$row->city_id}'>{$row->city_name}</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label class="form-label" for="area">Area</label>
                <div class="input-group">
                  <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-map-pin text-secondary"></i></span>
                  <select id="area" name="area" class="form-control border-start-0" required style="border-radius: 0 10px 10px 0 !important;">
                    <option selected disabled value="">Select Area</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="mechMobile">Mobile Number</label>
                <div class="input-group">
                  <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-phone text-secondary"></i></span>
                  <input type="text" id="mechMobile" pattern="[0-9]*" name="mobile" class="form-control border-start-0" placeholder="10-digit Mobile" required style="border-radius: 0 10px 10px 0 !important;" />
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label class="form-label" for="mechEmail">Email Address</label>
                <div class="input-group">
                  <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-envelope text-secondary"></i></span>
                  <input type="email" id="mechEmail" name="email" class="form-control border-start-0" placeholder="name@example.com" required style="border-radius: 0 10px 10px 0 !important;" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="mechExp">Experience (Years)</label>
                <div class="input-group">
                  <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-briefcase text-secondary"></i></span>
                  <input type="text" id="mechExp" pattern="[0-9]*" name="experience" class="form-control border-start-0" placeholder="e.g. 5" required style="border-radius: 0 10px 10px 0 !important;" />
                </div>
              </div>
              
              <div class="col-md-6 mb-3">
                <label class="form-label" for="mechRate">Hourly Rate (₹)</label>
                <div class="input-group">
                  <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-rupee-sign text-secondary"></i></span>
                  <input type="text" id="mechRate" pattern="[0-9]*" name="rate" class="form-control border-start-0" placeholder="e.g. 300" required style="border-radius: 0 10px 10px 0 !important;" />
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="mechType">Specialization</label>
              <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-cogs text-secondary"></i></span>
                <select name="mechanic_type" id="mechType" class="form-control border-start-0" required style="border-radius: 0 10px 10px 0 !important;">
                  <option selected disabled value="">Select Mechanic Type</option>
                  <option value="Engine">🔧 Engine Repair</option>
                  <option value="Electrical">⚡ Electrical &amp; Battery</option>
                  <option value="Car Washing">🚿 Car Washing &amp; Detailing</option>
                  <option value="Tyre & Wheel">🔩 Tyre &amp; Wheel Alignment</option>
                  <option value="AC Repair">❄️ AC Repair &amp; Gas Fill</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="mechPassword">Password</label>
                <div class="input-group password-wrapper">
                  <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-lock text-secondary"></i></span>
                  <input type="password" id="mechPassword" name="password" class="form-control border-start-0" placeholder="••••••••" required style="border-radius: 0 10px 10px 0 !important; padding-right: 45px !important;" />
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label" for="mechConfirmPassword">Confirm Password</label>
                <div class="input-group password-wrapper">
                  <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-lock text-secondary"></i></span>
                  <input type="password" id="mechConfirmPassword" name="confirmpassword" class="form-control border-start-0" placeholder="••••••••" required style="border-radius: 0 10px 10px 0 !important; padding-right: 45px !important;" />
                </div>
              </div>
            </div>

            <button type="submit" value="Sign Up" name="register" class="btn btn-custom w-100 py-3 fw-bold mt-3">
              <i class="fas fa-user-plus me-2"></i> Register Professional
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>