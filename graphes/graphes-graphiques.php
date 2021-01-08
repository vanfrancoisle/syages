<script>
var line1A = [0,5, 10, 15, 45];
var line1B = [0, 8, 10, 35, 45];
var line2A = [0, 8, 10, 35, 45];
var line2B = [0,7, 9, 21, 34];
var line3A = [50,	50,	24,	10,	11,	41,	44,	47,	55, 61,11,12];
var line3B = [28,	82,	55,	58,	99,	24,	47,	54,	75, 47,11,12];
var line4A = [50,	50,	24,	14,	41,	11,	44,	47,	55, 68,11,12];
var line4B = [12,	82,	45,	78,	99,	22,	17,	54,	75, 47,11,12];
var pieData =[200,1769];
var radarA = [50,	50,	24,	14,	41,	11,	44,	47,	55, 68,11,12];
var radarB = [12,	82,	45,	78,	99,	22,	17,	54,	75, 47,11,12];
</script>           
<script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                    // The data for our dataset
                    data: {
                labels: ['Semaine 1', 'Semaine 2', 'Semaine 3', 'Semaine 4'],
                datasets: [{
                    label: 'Absences Promo A',
                    backgroundColor: 'rgba(255, 99, 32,0)',
                    borderColor: 'rgb(255, 99, 32)',
                    data: line1A
                },{
                    label: 'Absences Promo B',
                    backgroundColor: 'rgba(255, 99, 32,0)',
                    borderColor: 'rgb(99, 255, 32)',
                    data: line1B
                }]
            },

            // Configuration options go here
            options: {
                title:{
                    display :true,
                    text : 'Evolutions des absences du mois'
                }
            }
});//end graph1
                var ctx2 = document.getElementById('myChart-2').getContext('2d');
                var chart = new Chart(ctx2, {
                // The type of chart we want to create
                type: 'line',

                    // The data for our dataset
                    data: {
                labels: ['Semaine 1', 'Semaine 2', 'Semaine 3', 'Semaine 4'],
                datasets: [{
                    label: 'Absences Promo A',
                    backgroundColor: 'rgba(255, 99, 132,0)',
                    borderColor: '#2196f3',
                    data: line2A
                },{
                    label: 'Absences Promo B',
                    backgroundColor: 'rgba(255, 99, 132,0)',
                    borderColor: '#4CAF50',
                    data: line2B
                }]
            },

            // Configuration options go here
            options: {
                title:{
                    display :true,
                    text : 'Evolutions des absences du mois (promo de l\'année dernière)'
                }
            }
});
var ctx3 = document.getElementById('myChart-3').getContext('2d');
                var chart = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
        datasets: [{
            label: 'Promo 2020 DAEU-A', // Name the series
            data: line3A, // Specify the data values array
            fill: false,
            borderColor: 'rgb(255, 99, 32)', // Add custom color border (Line)
            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        },
                  {
            label: 'Promo 2020 DAEU-B', // Name the series
            data: line3B, // Specify the data values array
            fill:false,
            borderColor: '#4CAF50', // Add custom color border (Line)
            backgroundColor: '#4CAF50', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        }]
    },
    options: {
        elements: {
            line: {
                tension: 0
            }
        },
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
    }
});
                var ctx4 = document.getElementById('myChart-4').getContext('2d');
                var chart = new Chart(ctx4, {
    type: 'line',
    data: {
        labels: ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
        datasets: [{
            label: 'Promo 2019 DAEU-A', // Name the series
            data: line4A, // Specify the data values array
            fill: false,
            borderColor: '#2196f3', // Add custom color border (Line)
            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        },
                  {
            label: 'Promo 2019 DAEU-A', // Name the series
            data: line4B, // Specify the data values array
            fill: false,
            borderColor: '#4CAF50', // Add custom color border (Line)
            backgroundColor: '#4CAF50', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        }]
    },
    options: {
        elements: {
            line: {
                tension: 0
            }
        },
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
    }
});
                
                var ctx5 = document.getElementById('myChart-5').getContext('2d');
                var chart = new Chart(ctx5, {
    type: 'radar',
    data: {
        labels: ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
        datasets: [{
            label: 'Promo 2019 DAEU-A', // Name the series
            data: radarA, // Specify the data values array
            fill: false,
            borderColor: '#2196f3', // Add custom color border (Line)
            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        },
                  {
            label: 'Promo 2019 DAEU-A', // Name the series
            data: radarB, // Specify the data values array
            fill: false,
            borderColor: '#4CAF50', // Add custom color border (Line)
            backgroundColor: '#4CAF50', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        }]
    },
    options: {
        elements: {
            line: {
                tension: 0
            }
        },
        title: {
            display:true,
            text:"Absences par promo"
        },
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
    }
});
                
                var ctx6 = document.getElementById('myChart-6').getContext('2d');
                var chart = new Chart(ctx6, {
    type: 'pie',
    data: {
      labels: ["Promo DAEU A", "Promo DAEU B"],
      datasets: [{
        label: "Promotion",
        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
        data: pieData
      }]
    },
    options: {
        elements: {
            line: {
                tension: 0
            }
        },
        title: {
            display:true,
            text:"Absences par promo"
        },
      responsive: true, 
      maintainAspectRatio: false, 
    }
});
            </script>