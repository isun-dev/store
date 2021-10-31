<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>상점</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<form name="form" method="get">
    <h1>액세스 토큰 요청</h1>
    <input type="button" value="액세스토큰요청" onclick="request_token()">
    <hr/>

    <h1>과일 목록 조회</h1>
    <span id="fruit_list"></span><br/>
    <input type="button" value="과일목록조회" onclick="product_list()">
    <hr/>

    <h1>채소 목록 조회</h1>
    <span id="vegetable_list"></span><br/>
    <input type="button" value="채소목록조회" onclick="item_list()">
    <hr/>

    <h1>가격 조회</h1>
    * 분류 선택:
    <select name="search">
        <option value="">선택하세요</option>
        <option value="fruits">과일</option>
        <option value="vegetables">채소</option>
    </select><br/>
    * 채소명 혹은 과일명을 입력해주세요: <input type="text" name="search_name" value="" size="10"
                                 onkeydown="return event.key != 'Enter';"/>

    <br/>
    * 가격(단위: 원): <span id="price"></span><br/><br/>
    <input type="button" value="가격조회" onclick="check_price()">
</form>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function request_token() {
        $.ajax({
            url: "/token",
            type: "get"
        }).done(function (data) {
            sessionStorage.setItem("token", data);
            alert("액세스 토큰 요청 성공");
        });
    }

    // 과일 목록 조회
    function product_list() {
        if (sessionStorage.getItem('token') == null) {
            alert("액세스 토큰을 요청해주세요.");
            return false;
        }
        $.ajax({
            url: "/product",
            type: "get",
            headers: {"Authorization": sessionStorage.getItem('token')},
        }).done(function (data) {
            $('#fruit_list').text(data);
        });
    }

    // 채소 목록 조회
    function item_list() {
        if (sessionStorage.getItem('token') == null) {
            alert("액세스 토큰을 요청해주세요.");
            return false;
        }
        $.ajax({
            url: "/item",
            type: "get",
            headers: {"Authorization": sessionStorage.getItem('token')},
        }).done(function (data) {
            $('#vegetable_list').text(data);
        });
    }

    // 채소와 과일 가격 조회
    function check_price() {
        if (sessionStorage.getItem('token') == null) {
            alert("액세스 토큰을 요청해주세요.");
            return false;
        }
        const kinds = document.getElementsByName('search')[0].value;
        let action_page;
        if (kinds == "fruits") {
            action_page = "/product";
        } else if (kinds == "vegetables") {
            action_page = "/item";
        } else {
            alert("분류를 선택해주세요.");
            return false;
        }
        if (form.search_name.value == "") {
            form.search_name.focus();
            alert("과일명 혹은 채소명을 입력해주세요.");
            return false;
        }
        const search_name = document.getElementsByName('search_name')[0].value.trim();
        $.ajax({
            url: action_page,
            type: "get",
            headers: {"Authorization": sessionStorage.getItem('token')},
            data: {
                name: search_name,
            }
        }).done(function (data) {
            $('#price').text(data);
        });
    }

</script>
