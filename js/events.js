const searchForm = document.getElementById('form1');
const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');
searchForm.addEventListener('submit', function(event) {
    event.preventDefault(); 

    const searchTerm = searchInput.value.trim().toLowerCase();

    if (searchTerm.length === 0) {
        searchResults.innerHTML = '';
        return;
    }
    searchResults.style.display = 'block';

    const results = [
        { name: 'Food Drive', oname: 'Organiser', time: '2h ago', date: '23/03/2023', tag: 'blue', place: 'Chennai'},
        { name: 'Fund Raiser',oname: 'Organiser', time: '2d ago', date: '10/03/2023', tag:'brown',place: 'Bangalore'},
        { name: 'Green Run',oname: 'Organiser', time: '3h ago', date: '1/04/2023',tag: 'red', place: 'Vellore'}
    ];

    const filteredResults = results.filter(result => result.name.toLowerCase().includes(searchTerm));

    if (filteredResults.length > 0) {
        const html = filteredResults.map(result => `
            <div class="search-results">
                <div class="card">
              <div class="card__body">
                <span class="tag tag-${result.tag}">Food</span>
                <h4>${result.name}</h4>
                <p><i class='far fa-calendar-alt' style='font-size:16px'></i>
                    ${result.date} </p>
                <p><i class="fa fa-map-pin" style="font-size:16px"></i>
                    ${result.place} </p>
              </div>
              <div class="card__footer">
                <div class="user">
                  <div class="user__info">
                    <h5>${result.oname}</h5>
                    <small>${result.time}</small>
                  </div>
                </div>
                <div class='buttons'>
                  <button type='button' class="register" >
                    Register
                  </button>
                  <button type='button' class="p1">
                    Know More
                  </button>
                </div>
              </div>
            </div>
            </div>
        `).join('');
        searchResults.innerHTML = html;
    } else {
        searchResults.innerHTML = 'No results found';
    }
});

var buttons = document.querySelectorAll(".register");

buttons.forEach(function(button) {
  button.addEventListener("click", function() {
    alert("Registered!!");
  });
});

var x = document.querySelector(".cross-btn");
x.addEventListener("click", function () {
    var y=document.getElementById('search-results');
    y.style.display="none";
});