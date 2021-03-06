@extends('layouts.app')
@section('content')

<!-- contact_wrapper start -->
<div class="contact_section m24_cover">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-md-12 col-sm-12">
                <div class="m24_heading_wrapper m24_cover text-center">

                    <h1>Edit YOUR MUSIC</h1>
                </div>
            </div>

            <div class="col-lg-10 offset-lg-1 col-md-12 col-sm-12 col-12">
                <form id="music_add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="overlay-load" style="display:none;" class="fileuploadoverlay">
                        <img src="/frontend/images/loader.gif" alt="loader">
                        <br>
                        Uploading...
                    </div>
                    <center id="form_result" style="margin-bottom:35px"> </center>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-pos">
                                <div class="form-group i-name">
                                    @hasrole ('Producer')
                                    <label for="genre">Genre of Beat</label>
                                    @endif
                                    @hasrole ('Artist')
                                    <label for="genre">Genre of Song</label>
                                    @endif
                                    <select class="form-control require genre" id="genre" name="genre_id">
                                        <option value="" disabled selected>Select Music Genre *</option>
                                        @foreach ($genres as $genre)
                                        <option value="{{$genre->id}}"
                                            {{$music->genre_id==$genre->id ? 'selected' :''}}>{{$genre->genre}}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-pos">
                                <div class="form-group i-name">
                                    @hasrole ('Producer')
                                    <label for="cover">Beat Title</label>
                                    <input type="text" class="form-control require" name="title" required=""
                                        placeholder="beat title*" value="{{$music->title}}">
                                    @endif
                                    @hasrole ('Artist')
                                    <label for="cover">Song Title</label>
                                    <input type="text" class="form-control require" name="title" required=""
                                        placeholder="song title*" value="{{$music->title}}">
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    @hasrole ('Producer')
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-pos">
                                <div class="form-group i-name">
                                    <label for="beat">Key of Beat</label>
                                    <select class="form-control require key" id="beat" name="key_id" required="">
                                        <option value="" disabled selected>Select Beat Key *</option>
                                        @foreach ($keys as $key)
                                        <option value="{{$key->id}}" {{$music->key_id==$key->id ? 'selected' :''}}>
                                            {{$key->key}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            @hasrole('Producer')
                            <div class="form-pos">
                                <div class="form-group i-name">

                                    <label for="cover">Tempo</label>
                                    <input type="text" class="form-control require" name="tempo" required=""
                                        placeholder="title*" value="{{$music->title}}"  value="{{$music->tempo_of_beat}}">

                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-e">
                                <div class="form-group i-name">
                                    @hasrole ('Producer')
                                    <label for="cover">Change Cover Art for Song  </label>
                                    @endif
                                    @hasrole ('Artist')
                                    <label for="cover">Change Cover Art for Song </label>
                                    @endif
                                    <input class="form-control" name="cover_art" id="cover" type="file"
                                        accept="image/*" />

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-e">
                                <div class="form-group i-name">
                                    @hasrole ('Producer')
                                    <label>Current Cover Art for Song </label><br>
                                    @endif
                                    @hasrole ('Artist')
                                    <label>Current Cover Art for Song </label><br>
                                    @endif
                                    
                                    <div class="list_image_gallery">
                                        @if ($music->cover_art == null)
                                            <p>No cever photo</p>
                                        @else
                                        <div class="icon-remove blue delete" id="imgwrapper{{$music->id}}">
                                            <img class="thumbnail" src="{{url('/uploadedCoverArts').'/'.$music->cover_art }}"
                                                alt="image" height="60" width="60" />
                                            <a href="#" onclick="deletepic(this)" class="photodelete" id="{{$music->id}}"><i
                                                    class="delete-button fa fa-trash"></i></a>
                                        </div>
                                        @endif                               
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-m">
                                <div class="form-group i-message">
                                    @hasrole ('Producer')
                                    <label for="description">Description of Beat</label>
                                    @endif
                                    @hasrole ('Artist')
                                    <label for="description">Description of Song</label>
                                    @endif
                                    <textarea class="form-control require" name="description" required="" rows="3"
                                        id="description" placeholder=" description">{{$music->description}}</textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                    @hasrole ('Artist')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-m">
                                <div class="form-group i-message">

                                    <label for="lyrics">Music Lyrics (optional)</label>
                                    <textarea class="form-control" name="lyrics" rows="30" id="lyrics"
                                        placeholder=" Paste lyrics">{{$music->lyrics}}</textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @hasrole ('Producer')
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-pos">
                                <div class="form-group i-name">

                                    <label for="music">Price range between $10 to $100</label>
                                    <input type="text" class="form-control require" name="price" required=""
                                        placeholder="price*" value="{{$music->price}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tb_es_btn_div">
                                <div class="response"></div>
                                <div class="tb_es_btn_wrapper">
                                    <button type="submit"><i class="flaticon-play-button"></i> Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- contact_wrapper end -->
<script src="/frontend/plugin/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
    ClassicEditor
		.create( document.querySelector( '#lyrics' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );

    $(document).ready(function() {
            $('.genre').select2();           
            $('.key').select2(); 
            

    });

    function deletepic(piccontext){
           var music_id = piccontext.id;
            // alert(music_id);
            var result = confirm("Want to delete?");
            if (result) {
                $.ajax({
                    url:"/file/destroy-pic/"+music_id,
                    beforeSend:function(){
                    // $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                    if (data.success) {
                       
                    $('#imgwrapper'+music_id).html('');
                    }
                    if(data.errors)
                    {
                       
                    
                    }
                    }
                    
                    });
            }
        }

    $("#music_add").on("submit", function (event) {
        event.preventDefault();
         $(".fileuploadoverlay").fadeIn();
        $.ajax({
            url: "{{route('file.update',$music->id)}}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",

            success:function(data){
                $(".fileuploadoverlay").fadeOut();
               if (data.errors) {
                    html =
                            '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" \
                        data-dismiss="alert">&times;</button><div class="alert-icon"><i class="icon-close"></i></div><div class="alert-message">\
                        <span><strong>Errors!</strong></span><br>';
                        for (
                            var count = 0;
                            count < data.errors.length;
                            count++
                        ) {
                            html +=
                                "<span>" +
                                data.errors[count] +
                                "</span><br>";
                                Lobibox.notify("error", {
                                    pauseDelayOnHover: true,
                                    continueDelayOnInactiveTab: false,
                                    position: "top right",
                                    icon: "fa fa-times-circle",
                                    msg: data.errors[count],
                                });
                        }
                        html += "</div></div>";   
                }
                if (data.warning) {
                    html =
                        '<div class="alert alert-warning">' +
                        data.warning +
                        "</div>";
                        Lobibox.notify("warning", {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: "top right",
                            icon: "fa fa-times-circle",
                            msg:  data.warning,
                        });
                }
                if (data.success) {
                    html =
                        '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" \
                    data-dismiss="alert">&times;</button><div class="alert-icon"><i class="icon-check"></i></div><div class="alert-message">\
                    <span><strong>Success!</strong> ' +
                        data.success +
                        "</span></div></div>";
                        Lobibox.notify("success", {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: "top right",
                            icon: "fa fa-times-circle",
                            msg: data.success,
                         });
                  
                }
                     $("#form_result").html(html);
                    setTimeout(function () {
                        $("#form_result").html("");
                    }, 6000);


            },
            error:function (data) {
                $(".fileuploadoverlay").fadeOut();
            Lobibox.notify("error", {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: "top right",
                icon: "fa fa-times-circle",
                msg: "Something went wrong",
            });

            },
        });
    });
</script>


@endsection