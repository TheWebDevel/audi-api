<html>
<head>
  <style>
  body {
  margin: 0;
  padding: 0;
}
* {
  box-sizing: border-box;
}
header .title-logo {
  width: 100%;
}
header .box {
  position: fixed;
  top: 0px;
  left: 0px;
  width: 100%;
  box-shadow: 1px 2px 2px 2px #888888;
}
header .box p {
  font-size: 40px;
  margin: 0px;
  color: #0c4e7d;
  text-align: center;
}
/**************/

main .sect-1 {
  width: 100%;
  margin-top: 70px;
}
main .box .box-3 h3 {
  text-align: center;
}
main .box .box-4 h3 {
  text-align: center;
}
  </style>
</head>
<body>
  <header>
    <section class="title-logo">
      <div class="container">
        <div class="box">
          <p>S.A.ENGINEERING COLLEGE</p>
        </div>
      </div>
    </section>
  </header>
  <main>
    <section class="sect-1">
      <div class="container">
        <div class="box">
          <div class="box-3">
            <h3><strong>ACTIVE EVENTS</strong></h3>
                            @foreach ($title as $sa)
                    {{$sa['title']}}

                @endforeach
          </div>
          <div class="box-4">
            <h3><strong>CANCELLED EVENTS</strong></h3>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
