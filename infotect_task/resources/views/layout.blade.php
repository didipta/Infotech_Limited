<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.24.2/dist/full.css" rel="stylesheet" type="text/css" />
     <script src="https://cdn.tailwindcss.com"></script>
    <title>@yield("title")</title>
</head>
<body>
    <header>
        <div tabindex="0" class="collapse border border-base-300 bg-base-100 rounded-box"> 
            <a href="/"><div class="collapse-title text-xl font-medium">
                <h1>Workspace</h1>
                <h1>Infotech</h1></a>
            </div>
          </div>
    </header>
    <div>
        @yield("content")
    </div>

        <footer class="footer footer-center items-center p-4 bg-neutral text-neutral-content">
            <div class="items-center grid-flow-col ">
              <p>Copyright © Workspaceit - All right reserved</p>
            </div> 
          </footer>
</body>
</html>