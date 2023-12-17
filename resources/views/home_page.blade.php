<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/css/home.css')}}">
    <title>Encurtador</title>
</head>
<body>

    <!--  ALERTA DE DUPLICIDADE-->
    @if(isset($mensagem))
        <script>
            alert("{{ $mensagem }}");
        </script>
    @endif

<div class="container" id="container">


	<div class="form-container sign-in-container">
		<form action="{{route('encurl')}}" method="POST" >
            @csrf
			<h1>ENCURTADOR SEBRAE-RR</h1>


			<input type="url" placeholder="Encurtar URL"  name="origin-url"/>
			<button id="encurtar">ENCURTAR</button>

		</form>
	</div>



</div>

<footer>
	<p>
        <p>&copy; 2023 Sebrae RR. Todos os direitos reservados.
	</p>
</footer>


<!--Injetando configurações javascript-->

<script src="{{asset('/js/login.js')}}"> </script>
  </body>

</html>
