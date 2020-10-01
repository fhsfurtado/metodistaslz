var markersData = [
  {
      lat: -2.492618,
      lng: -44.186736,
      nome: "Moradas da Ilha Residence",
      morada1:"Estrada Velha da Raposa, S/N",
      morada2: "Miritiua",
      codPostal: "São José de Ribamar/MA @ 65110-000" // não colocar virgula no último item de cada marcador
   },
   {
      lat: -2.499307,
      lng: -44.252380,
      nome: "Space Calhau 2",
      morada1:"Rua Duque de Caxias, S/N",
      morada2: "Altos do Calhau",
      codPostal: "São Luis/MA @65072-200" // não colocar virgula no último item de cada marcador
   },
   {
    lat: -2.501632,
    lng: -44.313890,
    nome: "Ilê Saint Louis",
    morada1:"Rua das Dálias, 1",
    morada2: "Ponta D'Areia",
    codPostal: "São Luis/MA @65077-552" // não colocar virgula no último item de cada marcador
 },
   {
      lat: 40.6247167,
      lng: -8.7129167,
      nome: "Village Del'este IV",
      morada1:"Rua São Jerônimo, 50",
      morada2: "Santa Bárbara",
      codPostal: "São Luis/MA @65059-820" // não colocar virgula no último item de cada marcador
   } // não colocar vírgula no último marcador
];

function displayMarkers(){

  // esta variável vai definir a área de mapa a abranger e o nível do zoom
  // de acordo com as posições dos marcadores
  var bounds = new google.maps.LatLngBounds();

  // Loop que vai percorrer a informação contida em markersData 
  // para que a função createMarker possa criar os marcadores 
  for (var i = 0; i < markersData.length; i++){

     var latlng = new google.maps.LatLng(markersData[i].lat, markersData[i].lng);
     var nome = markersData[i].nome;
     var morada1 = markersData[i].morada1;
     var morada2 = markersData[i].morada2;
     var codPostal = markersData[i].codPostal;

     createMarker(latlng, nome, morada1, morada2, codPostal);

     // Os valores de latitude e longitude do marcador são adicionados à
     // variável bounds
     bounds.extend(latlng); 
  }

  // Depois de criados todos os marcadores,
  // a API, através da sua função fitBounds, vai redefinir o nível do zoom
  // e consequentemente a área do mapa abrangida de acordo com
  // as posições dos marcadores
  map.fitBounds(bounds);
}
function createMarker(latlng, nome, morada1, morada2, codPostal){
  var marker = new google.maps.Marker({
     map: map,
     position: latlng,
     title: nome
  });

  // Evento que dá instrução à API para estar alerta ao click no marcador.
  // Define o conteúdo e abre a Info Window.
  google.maps.event.addListener(marker, 'click', function() {
     
     // Variável que define a estrutura do HTML a inserir na Info Window.
     var iwContent = '<div id="iw_container">' +
     '<div class="iw_title">' + nome + '</div>' +
     '<div class="iw_content">' + morada1 + '<br />' +
     morada2 + '<br />' +
     codPostal + '</div></div>';
     
     // O conteúdo da variável iwContent é inserido na Info Window.
     infoWindow.setContent(iwContent);

     // A Info Window é aberta com um click no marcador.
     infoWindow.open(map, marker);
  });
}

var map;
// Função de Inicialização do Mapa
  function initMap() {
    map = new google.maps.Map(document.getElementById('googleMap'), {
      center: {lat: -2.5604588, lng: -44.2000000},
      zoom: 12,
      mapTypeId: 'roadmap'
    });
  }

  // Maconha Pura
  // Cria a nova Info Window com referência à variável infoWindow.
  // O conteúdo da Info Window é criado na função createMarker.
  infoWindow = new google.maps.InfoWindow();

  // Evento que fecha a infoWindow com click no mapa.
  google.maps.event.addListener(map, 'click', function() {
     infoWindow.close();
  });

  // Chamada para a função que vai percorrer a informação
  // contida na variável markersData e criar os marcadores a mostrar no mapa
  displayMarkers();
}
google.maps.event.addDomListener(window, 'load', initMap);
