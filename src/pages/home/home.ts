import {ChangeDetectorRef, Component, ElementRef, ViewChild} from '@angular/core';
import { NavController } from 'ionic-angular';

declare const google;
import * as $ from 'jquery';
import {Http} from "@angular/http";

@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {

  tabBarElement: any;
  splash = true;

  map: any;
  @ViewChild('directionsPanel') directionsPanel: ElementRef;
  @ViewChild('map_canvas') mapElement: ElementRef;
  fetchDirection = true;
  currentLocationLat = null;
  currentLocationLong = null;
  patientLocation: any;
  marker: any;
  modeOfTravel = 'DRIVING';
  directionsService = new google.maps.DirectionsService;
  directionsDisplay = new google.maps.DirectionsRenderer;
  markerInfo = '';
  infoModal: any;

  constructor(public navCtrl: NavController, private _ref: ChangeDetectorRef, private http: Http) {
    this.tabBarElement = document.querySelector('.tabbar');
  }

  ionViewDidLoad(){

    this.tabBarElement.style.display = 'none';
    setTimeout(() => {
      this.splash = false;
      this.tabBarElement.style.display = 'flex';
    }, 4000);

    this.initializeMap();

    $(document).on('click','.cancelModal',() => {
      this.infoModal.close();
    });

    $(document).on('click','.acceptModal',() => {
      this.infoModal.close();
    });
  }

  initializeMap() {

    let locationOptions = {timeout: 20000, enableHighAccuracy: true};

    navigator.geolocation.getCurrentPosition((position) => {
        let options = {
          center: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
          zoom: 16,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        this.currentLocationLat = position.coords.latitude;
        this.currentLocationLong = position.coords.longitude;
        this.map = new google.maps.Map(document.getElementById("map_canvas"), options);
        this.marker = new google.maps.Marker({
          map: this.map,
          animation: google.maps.Animation.DROP,
          position: this.map.getCenter(),
          draggable: true
        });
        this.showMyLocation();
        this._ref.markForCheck();
      }, (error) => {
        console.log(error);
      }, locationOptions);
  }

  showMyLocation(){

    this.marker.addListener('dragend', () => {
      this.markerInfo = '<p><strong>Do You want to update this location as Patient\'s new Location?</strong></p>' +
        '<div><button class="acceptModal">Yes</button>    <button class="cancelModal">Cancel</button></div>';
      this.setModalContent(this.markerInfo);
      this.infoModal.open(this.map, this.marker);
    });

    this.marker.addListener('dragstart', () => {
      if (this.infoModal) {
        this.infoModal.close();
      }
    });

    google.maps.event.addListener(this.marker, 'click', () => {
      this.markerInfo = "<h4>You are here!</h4>";
      this.setModalContent(this.markerInfo);
      this.infoModal.open(this.map, this.marker);
    });
  }

  closeModal() {
    console.log('closes');
  }

  setModalContent(markerInfo) {
    this.infoModal = new google.maps.InfoWindow({
      content: markerInfo
    });
  }

  startNavigating(){

    this.getPatientsLocation();

    this.marker.setMap(null);

    this.directionsDisplay.setMap(this.map);
    this.directionsDisplay.setPanel(document.getElementById("directionsPanel"));

    let currentLocation = new google.maps.LatLng(this.currentLocationLat, this.currentLocationLong);

    this.directionsService.route({
      origin: currentLocation,
      destination: 'Mp nagar, Bhopal',
      travelMode: google.maps.TravelMode[this.modeOfTravel]
    }, (res, status) => {

      if(status == 'OK'){
        this.directionsDisplay.setDirections({routes: []});
        this.directionsDisplay.setDirections(res);
        this._ref.markForCheck();
      } else {
        console.warn(status);
      }
      this._ref.markForCheck();
    });

  }

  getPatientsLocation() {
    return this.http.get('http://localhost/app/getPatientLocation').subscribe( (res) => {
      this.patientLocation = res.json();
      console.log(this.patientLocation);
    })
  }

  modeChanged() {
    this.startNavigating();
  }

  findDirection() {
    this.fetchDirection = false;
    setTimeout(() => {
      this.startNavigating();
    }, 0);
    this._ref.markForCheck();
  }

  reset() {
    this.fetchDirection = true;
    this.initializeMap();
    this._ref.markForCheck();
  }

}
