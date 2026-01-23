# Daniil Grydin

---

## E01

```html
<button id='tr1-display'>Display</button>
<div id='tr1-pane-result' style='width:410px; border:1px solid black'>Result here!</div>
<script>
    document.getElementById('tr1-display').addEventListener('click', function(){display1();});
    
    function display1() {
        document.getElementById("tr1-pane-result").innerHTML = 'Strong desire brings strong results.';
    }
</script>
```

---

## E02

```html
<script>
function isdivisible(n, m){
    let result = n%m == 0;
    alert(result)
}
isdivisible(prompt("number:"), 15);
</script>
```

---

## E03

```html
<script>
{    
    let model = prompt("Enter a model name: ");
    let year = prompt("Enter an year: ");
    const car = {
        model: model,
        year: year,

        getModel: function(){
            return this.model;
        },

        setModel: function(newModel){
            this.model = newModel;
        },

        getYear: function(){
            return this.year;
        },

        setYear: function(newYear){
            this.year = newYear;
        },

        print: function(){
            return this.model + " " + this.year
        }
    }
    alert(car.getModel());
    car.setModel("Honda Civic")  // test case for .setModel()
    car.setYear(car.getYear()-1) // test cases for .getYear() and .setYear()
    alert(car.print());  // test case for .print()
}
</script>
```

---

## E04

```html
<script>
{
    // 1st function
    function requestArray(n){
        let arr = Array.from({length: n});
        for (let i = 0; i < n; i++){
            arr[i] = Number(prompt("enter #" + (i+1) + " number"));
        }
        return arr;
    }

    // 2nd function
    function average(arr){
        let avg = 0;
        for (let i = 0; i < arr.length; i++){
            avg += arr[i];
        }
        avg /= arr.length;
        return avg;
    }
    
    const data = requestArray(prompt("how many numbers to enter?"));  // get an array of at least 5 numbers 
    alert(data);
    alert(average(data));  // test case for the second function with data
}
</script>
```