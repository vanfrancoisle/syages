<footer>
                <ul>
                    <li><a href="mentionsleg.html">Mentions légales</a></li>
                    <li><a href="https://www.univ-paris13.fr/wp-content/uploads/livret-DAEU-presentiel_avril2020_v2.pdf">À Propos - Syages©</a></li>
                    <li><a href="http://ataraxy.xyz/">ATARAXY</a></li>
                </ul>
            </footer>
        </div>


    </div>
    <script>
    function searchFunction(searchbarID,tableID){
      var searchbar,table,filter,tr,td,i,j,txtValue,afficheTR;
      searchbar = document.getElementById(searchbarID);
      filter = searchbar.value.toUpperCase();
      table = document.getElementById(tableID);
      tr = table.getElementsByTagName("tr");
      for(i=1;i<tr.length;i++){
        td = tr[i].getElementsByTagName("td");
        for(j=0; j<td.length; j++){
            if(td[j]){
                txtValue = td[j].textContent || td[j].innerText;
                if(txtValue.toUpperCase().indexOf(filter)>-1){
                  afficheTR=true;
                  break;
                }else{
                  afficheTR=false;
                }
            }
        }
        if(afficheTR){
        tr[i].style.display='';}else{
          tr[i].style.display="none";
        }
      }
    }
    </script>
</body>
</html>
