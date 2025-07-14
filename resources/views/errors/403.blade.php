<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/css/403.css')}}">
     <title>403 Error - {{config('app.name')}}</title>
</head>
<body>
    <div class="room">
        <div class="cuboid">
            <div class="side"></div>
            <div class="side"></div>
            <div class="side"></div>
        </div>
        <div class="oops">
            <h2>OOPS!</h2>
            <p>  This action is unauthorized !.</p>
        </div>
        <div class="center-line">
            <div class="hole">
                <div class="ladder-shadow"></div>
                <div class="ladder"></div>
            </div>
            <div class="four">4</div>
            <div class="four">3</div>
            <div class="btn">
                <a href="{{route('admin.home')}}">BACK TO HOME</a>
            </div>
        </div>
    </div>
</body>
</html>