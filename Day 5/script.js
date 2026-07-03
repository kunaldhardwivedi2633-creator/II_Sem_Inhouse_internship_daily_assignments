const students = [
{
    name: "Kunal Dhar Dwivedi",
    roll: "25ESKCS195",
    branch: "CSE",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "Rahul Sharma",
    roll: "24ESKCS002",
    branch: "CSE",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "Kuldeep Singh",
    roll: "24ESKCS003",
    branch: "IT",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "Aman Verma",
    roll: "24ESKCS004",
    branch: "ECE",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "Priya Meena",
    roll: "24ESKCS005",
    branch: "CSE",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "Anjali Sharma",
    roll: "24ESKCS006",
    branch: "ME",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "Rohit Kumar",
    roll: "24ESKCS007",
    branch: "Civil",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "Deepak Yadav",
    roll: "24ESKCS008",
    branch: "IT",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "Neha Gupta",
    roll: "24ESKCS009",
    branch: "CSE",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "Karan Joshi",
    roll: "24ESKCS010",
    branch: "ECE",
    year: "2nd Year",
    course: "B.Tech"
},{
    name: "kunal sharma",
    roll: "24ESKCS012",
    branch: "ECE",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "bhavya sharma",
    roll: "24ESKCS012",
    branch: "ECE",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name: "sachin sharma",
    roll: "24ESKCS013",
    branch: "ECE",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name :"kamal sharma",
    roll: "24ESKCS014",
    branch: "ECE",
    year: "2nd Year",
    course: "B.Tech"
},
{
    name:"jitesh sharma",
    roll: "24ESKCS015",
    branch: "ECE",
    year: "2nd Year",
    course: "B.Tech"
}
];

function displayStudents() {

    let container = document.getElementById("studentContainer");

    container.innerHTML = "";

    document.getElementById("message").innerHTML = "";

    document.getElementById("totalStudent").innerHTML = students.length;

    for (let i = 0; i < students.length; i++) {

        container.innerHTML += `
        <div class="card">

            <h2>${students[i].name}</h2>

            <p><b>Roll No :</b> ${students[i].roll}</p>

            <p><b>Branch :</b> ${students[i].branch}</p>

            <p><b>Year :</b> ${students[i].year}</p>

            <p><b>Course :</b> ${students[i].course}</p>

        </div>
        `;
    }

}
function searchStudent() {

    let searchName = document.getElementById("search").value.trim();

    let container = document.getElementById("studentContainer");

    let message = document.getElementById("message");

    container.innerHTML = "";
    message.innerHTML = "";

    if (searchName === "") {
        displayStudents();
        return;
    }

    let found = false;

    for (let i = 0; i < students.length; i++) {

        if (students[i].name.toLowerCase().includes(searchName.toLowerCase())) {

            container.innerHTML += `
            <div class="card">
                <h2>${students[i].name}</h2>
                <p><b>Roll No :</b> ${students[i].roll}</p>
                <p><b>Branch :</b> ${students[i].branch}</p>
                <p><b>Year :</b> ${students[i].year}</p>
                <p><b>Course :</b> ${students[i].course}</p>
            </div>
            `;

            found = true;
        }
    }

    if (!found) {
        message.innerHTML = "Student is not in the college.";
    }
}

function resetStudents() {
    document.getElementById("search").value = "";
    document.getElementById("message").innerHTML = "";
    displayStudents();
}

function darkMode() {

    document.body.classList.toggle("dark");

    let btn = document.getElementById("modeBtn");

    if (document.body.classList.contains("dark")) {
        btn.innerHTML = "☀️ Light Mode";
    } else {
        btn.innerHTML = "🌙 Dark Mode";
    }
}

displayStudents();