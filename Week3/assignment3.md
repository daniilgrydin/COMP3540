# Daniil Grydin - T00712793

## Exercise 3

### Trial 1

```html
<style>
    #ddm {width: 50px;}
    #ddm ul {list-style: none; padding: 0; background-color: bisque; border: 1px solid black;display: none;margin: 0;position: absolute;top: 100%;}
    #ddm li {width: 120px;text-align: center;}
    #ddm li:hover {background-color: aqua;cursor: pointer;}
    #ddm {position: relative;}
    #ddm:hover > ul {display: block;}
</style>
<div id="ddm">
    <img src="menu_icon.png" width="50px" height="50px" />
    <ul>
    <li>Open</li>
    <li>Close</li>
    </ul>
</div>
```

### Trial 2

```html
<ul>
    <li id="open-content">Open</li>
    <li id="close-content">Close</li>
</ul>

<script>
    document
    .getElementById("open-content")
    .addEventListener("click", function (e) {
        alert(document.getElementById("open-content").innerHTML);
    });
    document
    .getElementById("close-content")
    .addEventListener("click", function (e) {
        alert(document.getElementById("close-content").innerHTML);
    });
</script>
```

### Trial 3

```html
<style>
    #ddm2 {width: 50px;}
    #ddm2 ul {list-style: none; padding: 0; background-color: bisque; border: 1px solid black;display: none;margin: 0;position: absolute;top: 100%;}
    #ddm2 li {width: 120px;text-align: center;}
    #ddm2 li:hover {background-color: aqua;cursor: pointer;}
    #ddm2 {position: relative;}
    #ddm2:hover > ul {display: block;}
</style>

<div id="ddm2">
    <img src="menu_icon.png" width="50px" height="50px" />
    <ul>
    <li id="open-content2">Open</li>
    <li id="close-content2">Close</li>
    </ul>
</div>

<script>
    document
    .getElementById("open-content2")
    .addEventListener("click", function (e) {
        alert(document.getElementById("open-content2").innerHTML);
    });
    document
    .getElementById("close-content2")
    .addEventListener("click", function (e) {
        alert(document.getElementById("close-content2").innerHTML);
    });
</script>
```

### Trial 4

```html
<style>
    #ddm3 {width: 50px;}
    #ddm3 ul {list-style: none; padding: 0; background-color: bisque; border: 1px solid black;display: none;margin: 0;position: absolute;top: 100%;}
    #ddm3 li {width: 120px;text-align: center;}
    #ddm3 li:hover {background-color: aqua;cursor: pointer;}
    #ddm3 {position: relative;}
    #ddm3:hover > ul {display: block;}
</style>
<div id="ddm3">
    <img src="menu_icon.png" width="50px" height="50px" />
    <ul>
    <li id="open-content3">Open</li>
    <li id="close-content3">Close</li>
    </ul>
</div>
<div
    id="content"
    style="display:none; position:relative width:100px; height:100px; border:1px solid Black; background-color:SkyBlue;"
>It works!</div>

<script>
    document
    .getElementById("open-content3")
    .addEventListener("click", function (e) {
        // window.getComputedStyle(document.getElementById("content")).display = "relative"
        document.getElementById("content").style.display = "block";
    });
    document
    .getElementById("close-content3")
    .addEventListener("click", function (e) {
        // window.getComputedStyle(document.getElementById("content")).display = "none"
        document.getElementById("content").style.display = "none";
    });
</script>
```