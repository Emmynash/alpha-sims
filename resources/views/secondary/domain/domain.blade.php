<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Alpha sims</title>
    <style>

    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-2">

            </div>
            <div class="col-12 col-md-8">
                <div class="card" style="margin-top: 200px;">

                    <div class="row">
                        <div class="col-12 col-md-6" style=" height: 250px; display: flex; flex-direction: column;justify-content: center;">
                            <div class="row">
                                <div class="col-12 col-md-1"></div>
                                <div class="col-12 col-md-10">
                                    <div style="margin: 10px;">
                                        <h5>Create sub-domain</h5>
                                    </div>
                                    <p>Enter your school name</p>
                                    <div class="form-group" style="margin: 10px;">
                                        <input type="text" class="form-control" id="schoolDomain" placeholder="e.g demo or demo_academy" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        {{-- <span class="input-group-text" id="basic-addon2">.alpha-sims-react.test</span> --}}
                                    </div>
                                    <p style="color:crimson; font-size: 9px;">Note: If school name has more than one word, try linking the words with underscore such as demo_high_school</p>
                                    <div class="form-group" style="margin: 10px;">
                                        <button class="btn btn-info btn-block" id="submitBtn">Proceed</button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-1"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6" style="height: 250px; background-image:url({{ asset('images/domainselect.svg') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-2">

            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        var domain = document.getElementById('schoolDomain')

        document.getElementById("submitBtn").addEventListener("click", loginRedirect);

        function loginRedirect() {
            window.location.href = "http://" + domain.value + ".alpha-sims.com/login";
        }
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>