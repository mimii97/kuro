@extends('layouts.master')


@section('title')

  

@endsection


@section('css')



@endsection




@section('content')

  <div class="container">


 
    <div class="row d-flex">
  <div class="col">
    <br><br><br><br><br>
  
    
    <main id="main" style="justify-content:center;">
  @foreach ($ICOs as $ICO)
  <div class="example" id="example1" value="{{$ICO->open_date}}">


    <div id="flipdown" class="flipdown"></div>
   
  </div>
      
  @endforeach
  
    </main><!-- End #main -->
  </div>
  </div></div>



  
  <script>


    let opendate =   new Date(document.getElementById("example1").getAttribute('value')).getTime()/1000;
   
    document.addEventListener('DOMContentLoaded', () => {
  
  // Unix timestamp (in seconds) to count down to
  var twoDaysFromNow =   opendate  ;
  
  // Set up FlipDown
  var flipdown = new FlipDown(twoDaysFromNow)
  
    // Start the countdown
    .start()
  
    // Do something when the countdown ends
    .ifEnded(() => {
      console.log('The countdown has ended!');
    });
  
 
  
  // Show version number
  var ver = document.getElementById('ver');
  ver.innerHTML = flipdown.version;
  });
  
  </script>

  
@endsection
