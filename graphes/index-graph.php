<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

        // The data for our dataset
        data: {
    labels: ['Mois 1', 'Mois 2', 'Mois 3', 'Mois 4'],
    datasets: [{
        label: label1A,
        backgroundColor: 'rgba(255, 99, 132,0)',
        borderColor: 'rgb(255, 99, 132)',
        data: data1A
    },{
        label: label1B,
        backgroundColor: 'rgba(255, 99, 132,0)',
        borderColor: 'rgb(99, 255, 132)',
        data: data1B
    }]
},

// Configuration options go here
options: {
    title:{
        display :true,
        text : 'Evolutions des notes du semestre'
    }
}
});//end graph1
    var ctx = document.getElementById('myChart-2').getContext('2d');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

        // The data for our dataset
        data: {
    labels: ['Mois 1', 'Mois 2', 'Mois 3', 'Mois 4'],
    datasets: [{
        label: label2A,
        backgroundColor: 'rgba(255, 99, 132,0)',
        borderColor: 'rgb(255, 99, 132)',
        data: data2A
    },{
        label: label2B,
        backgroundColor: 'rgba(255, 99, 132,0)',
        borderColor: 'rgb(99, 255, 132)',
        data: data2B
    }]
},

// Configuration options go here
options: {
    title:{
        display :true,
        text : 'Evolutions des notes du semestre dernier'
    }
}
});</script>
