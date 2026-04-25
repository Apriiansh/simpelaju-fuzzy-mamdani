import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
window.L = L;

import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png?url';
import markerIcon from 'leaflet/dist/images/marker-icon.png?url';
import shadowIcon from 'leaflet/dist/images/marker-shadow.png?url';

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: markerIcon2x,
    iconUrl: markerIcon,
    shadowUrl: shadowIcon,
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
