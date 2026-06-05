




<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>KPI Scorecard Calculator</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


</head>
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;
    background:linear-gradient(
        135deg,
        #1e3c72,
        #2a5298,
        #6a11cb,
        #2575fc
    );
}

.container{
    width:100%;
    max-width:950px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(20px);
    border-radius:25px;
    padding:30px;
    box-shadow:0 15px 40px rgba(0,0,0,.25);
    color:#fff;
}

.header{
    text-align:center;
    margin-bottom:30px;
}

.header h1{
    font-size:32px;
}

.header p{
    opacity:.8;
}

.kpi-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.kpi-card{
    background:rgba(255,255,255,.15);
    padding:20px;
    border-radius:18px;
}

.kpi-card h3{
    margin-bottom:8px;
}

.target{
    font-size:13px;
    opacity:.8;
    margin-bottom:10px;
}

input{
    width:100%;
    padding:12px;
    border:none;
    outline:none;
    border-radius:10px;
    background:white;
    font-size:15px;
}

.btn{
    width:100%;
    margin-top:25px;
    padding:14px;
    border:none;
    border-radius:12px;
    background:white;
    color:#2575fc;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-2px);
}

.results{
    margin-top:30px;
    display:none;
}

.summary{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.table-card,
.score-card{
    background:rgba(255,255,255,.15);
    padding:20px;
    border-radius:18px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:10px;
    text-align:left;
}

th{
    border-bottom:1px solid rgba(255,255,255,.2);
}

.score-circle{
    width:150px;
    height:150px;
    margin:auto;
    border-radius:50%;
    border:8px solid white;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:28px;
    font-weight:bold;
}

.rating{
    margin-top:10px;
    text-align:center;
    font-size:22px;
    font-weight:600;
}

.flag{
    margin-top:10px;
    text-align:center;
    font-size:24px;
}

@media(max-width:768px){
    .summary{
        grid-template-columns:1fr;
    }
}

</style>
<body>

<div class="container">

    <div class="header">
        <h1> KPI Scorecard Calculator</h1>
        <p>Employee Performance Evaluation Dashboard</p>
    </div>

    <div class="kpi-grid">

        <div class="kpi-card">
            <h3> Sales Revenue</h3>
            <div class="target">
                Target: ₹12,00,000 | Weight: 40%
            </div>

            <input
                type="number"
                id="sales"
                placeholder="Enter actual sales">
        </div>

        <div class="kpi-card">
            <h3>Proposals Won</h3>
            <div class="target">
                Target: 10 | Weight: 30%
            </div>

            <input
                type="number"
                id="proposals"
                placeholder="Enter proposals won">
        </div>

        <div class="kpi-card">
            <h3> Team Satisfaction</h3>
            <div class="target">
                Target: 4.0 | Weight: 30%
            </div>

            <input
                type="number"
                step="0.1"
                id="satisfaction"
                placeholder="Enter satisfaction score">
        </div>

    </div>

    <button class="btn" onclick="calculate()">
        Calculate Performance Score
    </button>

    <div class="results" id="results">

        <div class="summary">

            <div class="table-card">

                <h3>KPI Breakdown</h3>

                <table>
                    <thead>
                    <tr>
                        <th>KPI</th>
                        <th>Ach %</th>
                        <th>W.Score</th>
                    </tr>
                    </thead>

                    <tbody id="tableBody"></tbody>
                </table>

            </div>

            <div class="score-card">

                <div
                    class="score-circle"
                    id="overallScore">
                    0%
                </div>

                <div
                    class="rating"
                    id="rating">
                </div>

                <div
                    class="flag"
                    id="flag">
                </div>

            </div>

        </div>

    </div>

</div>

<script>

const kpis = [
{
    name:"Sales Revenue",
    id:"sales",
    target:1200000,
    weight:40
},
{
    name:"Proposals Won",
    id:"proposals",
    target:10,
    weight:30
},
{
    name:"Team Satisfaction",
    id:"satisfaction",
    target:4,
    weight:30
}
];

function calculate(){

    let totalScore = 0;
    let rows = "";

    kpis.forEach(kpi=>{

        const actual =
        Number(
            document.getElementById(kpi.id).value
        ) || 0;

        const achievement =
        Math.min(
            (actual/kpi.target)*100,
            200
        );

        const weighted =
        achievement *
        (kpi.weight/100);

        totalScore += weighted;

        rows += `
        <tr>
            <td>${kpi.name}</td>
            <td>${achievement.toFixed(1)}%</td>
            <td>${weighted.toFixed(1)}</td>
        </tr>
        `;
    });

    let rating="";
    let flag="";

    if(totalScore>=120){
        rating=" Rating 5 - Outstanding";
        flag=" Star Performer";
    }
    else if(totalScore>=101){
        rating=" Rating 4 - Exceeds Target";
    }
    else if(totalScore>=100){
        rating=" Rating 3 - Meets Target";
    }
    else if(totalScore>=80){
        rating=" Rating 2 - Below Target";
    }
    else{
        rating=" Rating 1 - Significantly Below";
        flag=" PIP Threshold";
    }

    document.getElementById(
        "tableBody"
    ).innerHTML = rows;

    document.getElementById(
        "overallScore"
    ).innerHTML =
    totalScore.toFixed(1)+"%";

    document.getElementById(
        "rating"
    ).innerHTML = rating;

    document.getElementById(
        "flag"
    ).innerHTML = flag;

    document.getElementById(
        "results"
    ).style.display = "block";
}

</script>

</body>
</html>
