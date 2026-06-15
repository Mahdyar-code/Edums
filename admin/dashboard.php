<!doctype html>
<html lang="fa" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>سیستم مدیریت مرکز آموزشی</title>

    <link
      href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="dashboard.css" />
  </head>
  <body>
    <div class="container">
      <div class="sidebar">
        <div class="logo">🎓 EMS</div>

        <ul class="menu">
          <li class="active"><a href="#">🏠 داشبورد</a></li>
          <li><a href="#">👨‍🎓 شاگردان</a></li>
          <li><a href="#">👨‍🏫 استادان</a></li>
          <li><a href="#">👔 کارمندان</a></li>
          <li><a href="#">🏫 صنف‌ها</a></li>
          <li><a href="#">💳 پرداخت‌ها</a></li>
          <li><a href="#">📝 امتحانات</a></li>
          <li><a href="#">📊 گزارشات</a></li>
          <li><a href="#">⚙️ تنظیمات</a></li>
        </ul>
      </div>

      <div class="main">
        <div class="navbar">
          <input class="search" placeholder="جستجو..." />

          <div class="right-box">
            <button class="dark-btn" onclick="toggleDark()">🌙 حالت شب</button>

            <div class="profile"><a href="#">خروج از سیستم</a></div>
          </div>
        </div>

        <div class="hero">
          <h1>خوش آمدید محمد موسی مهدیار 👋</h1>

          <p>سیستم مدیریت مرکز آموزشی - داشبورد مدیریتی</p>
        </div>

        <div class="stats">
          <div class="card">
            <div class="show">
              <div class="icon blue">👨‍🎓</div>
              <div class="number">1,250</div>
            </div>
            <div class="label">دانشجویان</div>
          </div>

          <div class="card">
            <div class="show">
              <div class="icon green">👨‍🏫</div>
              <div class="number">85</div>
            </div>
            <div class="label">استادان</div>
          </div>

          <div class="card">
            <div class="show">
              <div class="icon orange">🏫</div>
              <div class="number">32</div>
            </div>
            <div class="label">صنف فعال</div>
          </div>

          <div class="card">
            <div class="show">
              <div class="icon red">💰</div>
              <div class="number">850,000</div>
            </div>
            <div class="label">درآمد ماهانه</div>
          </div>
          <div class="card">
            <div class="show">
              <div class="icon red">💰</div>
              <div class="number">850,000</div>
            </div>
            <div class="label">مصارف </div>
          </div>
          <div class="card">
            <div class="show">
              <div class="icon red">💰</div>
              <div class="number">850,000</div>
            </div>
            <div class="label">درآمد خالص </div>
          </div>
          
        </div>

        <div class="content">
          <div>
            <div class="panel">
              <h3>دانشجویان برتر </h3>

              <table class="table">
                <tr>
                  <th>ID</th>
                  <th>نام</th>
                  <th>صنف</th>
                  <th>نمره</th>
                </tr>

                <tr>
                  <td>1</td>
                  <td>احمد</td>
                  <td>React</td>
                  <td><span class="status ">88</span></td>
                </tr>

                <tr>
                  <td>12</td>
                  <td>محمد</td>
                  <td>Database</td>
                  <td><span class="status ">87</span></td>
                </tr>

                <tr>
                  <td>3</td>
                  <td>علی</td>
                  <td>Java</td>
                  <td><span class="status ">88.3</span></td>
                </tr>
              </table>
            </div>
          </div>

         
        </div>
      </div>
    </div>

    <script>
      function toggleDark() {
        document.body.classList.toggle("dark");
      }
    </script>
  </body>
</html>
