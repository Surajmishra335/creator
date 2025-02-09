<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Social Platforms</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="row mb-3">
              <div class="col-sm-10">
                <select class="form-select" name="social_platform_name" id="social_platform_name" aria-label="Default select example">
                  <option selected disabled>Social Platforms</option>
                  @foreach ($social_platforms as $social)
                      
                  <option value="{{$social->id}}" url="{{$social->url}}">{{$social->platform_name}}</option>
                  @endforeach
                 
                </select>
              </div>
          </div>

          <div class="row mb-3">
              <div class="col-sm-10">
                <input type="text" class="form-control" name="social_platform_profile_url" id="social_platform_profile_url" placeholder="Profile Url">
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="social_platform_add" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>




  <script>
    $(document).ready(function () {

        // When a user selects a social platform
        $("#social_platform_name").change(function () {
            let selectedOption = $(this).find("option:selected");
            let baseUrl = selectedOption.attr("url");

            if (baseUrl) {
                $("#social_platform_profile_url").val(baseUrl + "/");
            } else {
                $("#social_platform_profile_url").val("");
            }
        });

        $("#social_platform_add").click(function () {

            let platforms_id = $("#social_platform_name").val();

            let profile_url = $("#social_platform_profile_url").val();

            let selectedPlatform = $("#social_platform_name option:selected");
            
            let expectedBaseUrl = selectedPlatform.attr("url");

            // Validation
            if (!platforms_id) {
                toastr.error("Please select a social platform.", "Error");
                return;
            }

            if (!profile_url.startsWith(expectedBaseUrl + "/") || profile_url === expectedBaseUrl + "/") {
                toastr.error("Please enter a valid profile URL for the selected platform.", "Error");
                return;
            }

            $.ajax({
                url: "{{ route('social-platform-add') }}", // Laravel route name
                type: "POST",
                data: {
                    platforms_id: platforms_id,
                    profile_url: profile_url,
                    _token: "{{ csrf_token() }}" // CSRF token
                },
                success: function (response) {
                    $("#add_social_platforms").modal("hide"); // Close modal
                    toastr.success(response.message, "Success", {
                        timeOut: 3000, // Auto close after 3 sec
                        progressBar: true
                    });
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    alert("Error adding social platform.");
                    console.log(xhr.responseText);
                }
            });
        });
    });
  </script>

