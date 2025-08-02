@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3><i class="fas fa-eye"></i> Aperçu du Cahier de Charges</h3>
    <div class="embed-responsive" style="height: 80vh;">
        <iframe src="{{ $pdfUrl }}" width="100%" height="100%" style="border: none;"></iframe>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
@endsection