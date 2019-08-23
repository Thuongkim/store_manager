<!DOCTYPE html>
<html>
<head>
    <title>Upload Multiple Images using dropzone.js and Laravel</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script>
</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Upload Multiple Images using dropzone.js and Laravel</h1>
            {!! Form::open([ 'route' => [ 'dropzone.store' ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
            <div>
                <h3>Upload Multiple Image By Click On Box</h3>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


<script type="text/javascript">
        Dropzone.options.imageUpload = {
            maxFilesize         :       1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif"
        };
</script>


</body>
</html>