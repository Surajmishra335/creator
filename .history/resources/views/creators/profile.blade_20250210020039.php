@extends('layouts.app')

@section('content')

<style>
    .highlight-card {
      background-color: #fff;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .highlight-card:hover {
      background-color: #ced4da;
    }
    .highlight-card i {
      font-size: 2rem;
      color: #4154f1;
      margin-bottom: 10px;
    }
    .section-title {
      margin-bottom: 40px;
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
    }
</style>

<div class="container">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Users</li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->
  
      <section class="section profile">
        <div class="row">
          <div class="col-xl-4">
  
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
  
                @if(auth()->user()->profile_picture)
                    <img src="{{ asset('creator/public/storage/profile_pics/' . auth()->user()->profile_picture) }}" width="100" height="100" class="rounded-circle">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=100&background=3498db&color=ffffff" alt="Profile Picture" class="rounded-circle">

                @endif
                <h2>{{auth()->user()->name}}</h2>
                <h3>{{auth()->user()->email}}</h3>
                <div class="social-links mt-2">
                  <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                  <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                  <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                  <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
  
          </div>
  
          <div class="col-xl-8">
  
            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
  
                  <li class="nav-item">
                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                    </li>
                    
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                    </li>
                    
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#platforms">Platforms</button>
                  </li>
  
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                  </li>
  
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                  </li>
  
                </ul>
                <div class="tab-content pt-2">

                    <div class="tab-pane  fade show profile-overview" id="platforms">
                        <span class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title">Your Platforms Present</h5>
                            <button type="button" class="btn btn-outline-primary" id="add_new_social_platform">Add New</button>
                        </span>
                        <div class="row g-4">
                            <!-- Card 1 -->
                            @forelse ($social_platforms as $social)
                            <div class="col-md-3 col-sm-6">
                                <div class="highlight-card">
                                  <i class="bi bi-{{$social->logo}}"></i>
                                  @if ($social->id == 3)
                                    <h5>{{$yt_subscriber[auth()->user()->id]}} Subscribers</h5>
                                    
                                  @else
                                    <h5>70+ Screens</h5>
                                  @endif
                                </div>
                            </div>
                            @empty
                                <h4>No platform added yet, start adding your platforms</h4>
                            @endforelse
                        </div>
                        <div class="modal fade" id="add_social_platforms" tabindex="-1"></div>
                    </div>
  
                  <div class="tab-pane fade show profile-overview" id="profile-overview">
                    <h5 class="card-title">About</h5>
                    <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>
  
                    <h5 class="card-title">Profile Details</h5>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Full Name</div>
                      <div class="col-lg-9 col-md-8">Kevin Anderson</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Company</div>
                      <div class="col-lg-9 col-md-8">Lueilwitz, Wisoky and Leuschke</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Job</div>
                      <div class="col-lg-9 col-md-8">Web Designer</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Country</div>
                      <div class="col-lg-9 col-md-8">USA</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Address</div>
                      <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Phone</div>
                      <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                    </div>
  
                  </div>
  
                  <div class="tab-pane active fade profile-edit pt-3" id="profile-edit">
  
                    <!-- Profile Edit Form -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                            <div class="col-md-8 col-lg-9">
                                <!-- Display Existing Profile Picture -->
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset('creator/public/storage/profile_pics/' . auth()->user()->profile_picture) }}" width="100" height="100" class="rounded-circle">
                                @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=100&background=3498db&color=ffffff" alt="Profile Picture" class="rounded-circle">

                                @endif
                            <div class="pt-2">
                                <label class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" name="profile_pic">
                            </div>
                            </div>
                        </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form><!-- End Profile Edit Form -->
  
                  </div>
  
                  <div class="tab-pane fade pt-3" id="profile-settings">
  
                    <!-- Settings Form -->
                    <form>
  
                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                        <div class="col-md-8 col-lg-9">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="changesMade" checked>
                            <label class="form-check-label" for="changesMade">
                              Changes made to your account
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="newProducts" checked>
                            <label class="form-check-label" for="newProducts">
                              Information on new products and services
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="proOffers">
                            <label class="form-check-label" for="proOffers">
                              Marketing and promo offers
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                            <label class="form-check-label" for="securityNotify">
                              Security alerts
                            </label>
                          </div>
                        </div>
                      </div>
  
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form><!-- End settings Form -->
  
                  </div>
  
                  <div class="tab-pane fade pt-3" id="profile-change-password">
                    <!-- Change Password Form -->
                    <form>
  
                      <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="password" type="password" class="form-control" id="currentPassword">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="newpassword" type="password" class="form-control" id="newPassword">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                        </div>
                      </div>
  
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                      </div>
                    </form><!-- End Change Password Form -->
  
                  </div>
  
                </div><!-- End Bordered Tabs -->
  
              </div>
            </div>
  
          </div>
        </div>
      </section>

  </div>
@endsection
    
