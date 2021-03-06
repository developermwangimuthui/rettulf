<div class="modal fade lang_m24_banner" id="register_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="m24_language_box m24_cover">
                        <h1>Register / Sign Up</h1>
                        <p>for unlimited music streaming & a personalised experience</p>
                    </div>
                    <div class="login_form_wrapper">
                        <div class="icon_form comments_form">

                            <input type="text" class="form-control" name="username" placeholder="Enter your Username">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="icon_form comments_form">

                            <input type="text" class="form-control" name="email" placeholder="Enter Email Address*">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="icon_form comments_form">
                            <select name="location" class="form-control" id="">
                                @foreach ($locations ?? '' as $location)
                            <option value="{{$location->id}}">{{$location->location}}</option>
                                @endforeach
                            </select>
                       
                            <i class="fas fa-map-marker"></i>
                        </div>
                        <div class="icon_form comments_form">

                            <input type="password" class="form-control" placeholder="Enter Password *">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="icon_form comments_form">
                            <select name="designation" id="" class="form-control">
                                <option value="">Select Your Designation </option>
                                <option value="producer">Producer</option>
                                <option value="artist">Artist</option>
                            </select>
                          <i class="fas fa-lock"></i>
                        </div>
                        <div class="icon_form comments_form">

                            <input type="password" class="form-control" placeholder="confirm password*">
                            <i class="fas fa-lock"></i>
                        </div>

                    </div>
                    <div class="lang_apply_btn_wrapper m24_cover">
                        <div class="lang_apply_btn">

                            <a href="#">register</a>

                        </div>
                        <div class="cancel_wrapper">
                            <a href="#" class="" data-dismiss="modal">cancel</a>
                        </div>
                        <div class="dont_have_account m24_cover">
                            <p>Don’t have an acount ? <a href="#login_modal" data-toggle="modal">login here</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>