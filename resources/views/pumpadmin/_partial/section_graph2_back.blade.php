<div class="card mb-3" id="Graph2">
    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">
            <h4>Products Wise</h4>
            <div class="btn btn-link   p-0">
                <i class="fas fa-chart-bar fa-lg d-none"></i>
                <i class="fas fa-table fa-lg "></i>
            </div>
        </div>
    </div>
    <div class="card-body overflow-hidden d-flex">
        {{-- <canvas id="chartTwo" height="200px" class="w-100"></canvas> --}}
        <svg width="100%" height="100%"></svg>
        {{-- <div id="series_chart_div"></div> --}}
        <div id="chartTwoData" class="d-none">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                    {{-- @foreach ($admin_dashboard_data->top5Products as $product)
                                <tr>
                                    <td>{{ $product->productName }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->amount }}</td>
                                </tr>
                            @endforeach --}}
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://d3js.org/d3.v5.min.js"></script>
<script src= "
https://d3js.org/d3-color.v1.min.js">
</script>
<script src= "
https://d3js.org/d3-interpolate.v1.min.js">
</script>
<script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
<script>
    var product_sales= {{ Js::from($product_sales) }};
    var labels = {{ Js::from($product_sales_labels) }};

    // var a = [ "Foo", "Bar", "Test", "Other" ];
    // var b = [ 159, 120, 200, 1230 ];
//using for loop
    var c = [];

    for (var i = 0; i < labels.length; i++) {
        c.push({name:labels[i] ,value:product_sales[i]});

    }
    //max value
    var max = Math.max.apply(Math, product_sales);
   if(max>10000){
         max=max/10000;
   }
    else if (max>1000)
   {
       max=max/1000;
   }
   else if(max>100){
    max=max/100;
   }
// console.log(max);
    // var data = [
    //   {name: "Product 1", value: 100},
    //   {name: "Product 2", value: 60},
    //   {name: "Product 3", value: 30}
    // ];
    data=c;
    // console.log(data);
    var svg = d3.select("svg")
      .attr("width","100%")
      .attr("height", 200)
        .attr("viewBox", "0 0 100% 100%")
        .attr("preserveAspectRatio", "xMidYMid meet")
        .attr("class", "svg-content-responsive")
        .attr("style", "background-color: #383838")
        .attr("xmlns", "http://www.w3.org/2000/svg")
        .attr("xmlns:xlink", "http://www.w3.org/1999/xlink")
        .attr("version", "1.1")
        .attr("baseProfile", "full")
        .attr("xmlns:ev", "http://www.w3.org/2001/xml-events")
        .attr("xmlns:inkscape", "http://www.inkscape.org/namespaces/inkscape")
        .attr("xmlns:sodipodi", "http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd")
      ;

    var circles = svg.selectAll("circle")
      .data(data)
      .enter()
      .append("circle")
      .attr("cx", "50%")
      .attr("cy", (d, i) => 100 + i * 20)
      .attr("r",  d =>  d.value/400*max )
      .attr("fill", (d, i) => d3.schemeCategory10[i]);

    var labels = svg.selectAll("text")
      .data(data)
      .enter()
      .append( "text" )
      .text(d => d.name)
      .attr("x", (d, i) => 100 + i * 50)
        .attr("y", (d, i) => 100 + i * 20)
        .attr("dy", 5)
        .attr("text-anchor", "middle")
        .attr("font-size", 14)
        .attr("fill", (d, i) => {
    if (d.value > 70) return "white"; // set the fill color to red if the value is greater than 70
    if (d.value > 30) return "orange"; // set the fill color to orange if the value is greater than 30
    return "green"; // set the fill color to green otherwise
  });

//         circles.on("mouseover", function(d) {
//   d3.select(this).style("opacity", 0.5);
//   svg.append("text")
//     .attr("x", d3.mouse(this)[0])
//     .attr("y", d3.mouse(this)[1])
//     .text(d.value)
//     .attr("fill", "white")
//     .attr("text-anchor", "middle");
// });

// circles.on("mouseout", function(d) {
//   d3.select(this).style("opacity", 1);
//   svg.selectAll("text").remove();
// });
</script>
