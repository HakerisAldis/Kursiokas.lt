@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('course.create') }}" enctype="multipart/form-data">
    @csrf
    <div class="justify-content-center row">
        <div class="card-body container row justify-content-center pt-0">
            <h1 class="main-title pb-0 text-break h-auto">Naujo kurso pridėjimas</h1>
        </div>

        <div class="pt-1 card-body justify-content-center container border-bottom row">

            <div class="col-3">
                <div class="input-group row mr-2 ml-2 w-100 h-100 img-area">
                    <img id="courseImage" class="img-fluid p-0">
                </div>
            </div>

            <div class="col-9">
                <div class="row mb-2 ml-1">
                    <div class="w-75">
                        <input name="name" type="text" class="form-control" placeholder="Kurso pavadinimas" required>
                    </div>
                    <div class="w-25 pl-1">
                    <input name="scope" type="text" class="form-control" placeholder="Sritis" required>
                    </div>
                </div>

                <div class="row mb-2 ml-1">
                    <div class="w-50">
                        <input name="address" type="text" class="form-control" placeholder="Adresas" required>
                    </div>
                    <div class="w-25 pl-1">
                        <input name="city" type="text" class="form-control" placeholder="Miestas" required>
                    </div>
                </div>

                <div class="row mb-2 ml-1 mr-0 align-items-center d-flex justify-content-between">
                    <div class="w-30 float-start">
                        <label class="label-font">Įkelkite kurso nuotrauką:</label>
                        <div class="row ml-1">
                            <div class="w-auto">
                                <label for="formFile" class="btn btn-secondary">Pasirinkti
                                    <input name="image" class="form-control" type="file" id="formFile" accept="image/*" onchange="showPreview(event);" hidden>
                                </label>
                            </div>
                            <div class="w-60 d-flex align-items-center pt-2">
                                <p id="courseImageText" class="pl-1 text-truncate">Nepasirinktas failas!</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-40 pt-4 row">
                        <div class="w-50">
                            <input id="date" name="date" type="date" class="form-control" placeholder="Data" required>
                        </div>
                        <div class="w-50 pl-1">
                            <input name="time" type="time" class="form-control" placeholder="Laikas" required>
                        </div>
                    </div>

                    <div class="w-30 pt-4 ml-2 row">
                        <div class="w-50">
                            <input name="price" type="number" class="form-control" placeholder="Kaina" required>
                        </div>
                        <div class="w-50 pl-1">
                            <input name="seats" type="number" class="form-control" placeholder="Vietų skaičius" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-3 card-body container row">
            <div class="col">
                <div class="row">
                    <h1 class="main-title pb-0">Kurso aprašymas:</h1>
                </div>

                <div class="row">
                    <textarea name="description" rows="12" class="w-100 form-control" required></textarea>
                </div>
            </div>
        </div>

        <div class="container row d-flex justify-content-end">
            <input type="submit" class="btn btn-primary" value="Sukurti kursą">
        </div>
    </div>
</form>

<script>
    var today = new Date();
    var minDate = new Date(today.setDate(today.getDate() + 1)).toISOString().split("T")[0];
    console.log(minDate);
    document.getElementById("date").setAttribute("min", minDate);

    function showPreview(event){
        if(event.target.files.length > 0){
            let src = URL.createObjectURL(event.target.files[0]);
            let preview = document.getElementById("courseImage");
            let fileName = document.getElementById("courseImageText");
            preview.src = src;
            fileName.innerHTML = event.target.files[0].name;
        }
    }
</script>
@endsection
