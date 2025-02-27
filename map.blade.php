<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Mapbox
                </div>
                <div class="card-body">
                    <div wire:ignore id='map' style='width: 100%; height: 75vh;'></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Form
                </div>
                <div class="card-body">
                    <form @if ($isEdit)
                            wire:submit.prevent="updateLocation"
                        @else
                            wire:submit.prevent="saveLocation"
                        @endif>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input wire:model="long" type="text" class="form-control">
                                    @error('long')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input wire:model="lat" type="text" class="form-control">
                                    @error('lat')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input wire:model="title" type="text" class="form-control">
                            @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                            
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea wire:model="description"  class="form-control"></textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Picture</label>
                            <div class="custom-file">
                                <input wire:model="image" type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            @error('image')<small class="text-danger">{{ $message }}</small>@enderror
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="img-fluid">
                            @endif

                            @if ($imageUrl && !$image)
                                <img src="{{ asset('/storage/public'.$imageUrl) }}" class="img-fluid">
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark text-white btn-block">{{ $isEdit ? "Update Location" : "Submit Location" }}</button>
                            @if ($isEdit)
                                <button wire:click="deleteLocation"type="button" class="btn btn-danger text-white btn-block">Delete Location</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

    
        const defaultLocation = [109.00963,-7.72722]

        mapboxgl.accessToken = '{{ env("MAPBOX_KEY") }}';
        const map = new mapboxgl.Map({
            container: 'map', // container ID 
            center: defaultLocation, // starting position [lng, lat]
            zoom: 10, // starting zoom
        });


        // const geoJson = {
        //     "type": "FeatureCollection",
        //     "features": [
        //         {
        //             "type": "Feature",
        //             "geometry": {
        //                 "coordinates": [109.008938, -7.738448],
        //                 "type": "Point"
        //             },
        //             "properties": {
        //                 "locationId": "20300574",
        //                 "title": "SMP NEGERI 1 CILACAP",
        //                 "image": "https://assets.pikiran-rakyat.com/crop/0x0:0x0/750x500/photo/2023/02/23/255560508.jpg",
        //                 "description": "SMP Negeri 1 Cilacap, dulu hanya bernama SMP Negeri. Hal ini dikarenakan saat itu hanya satu-satunya SMP yang ada pada masa itu (sekitar tahun 1944-an). Sebelum menjadi SMP Negeri, gedung yang sekarang berada di Jl. Jend. A. Yani no 15 ini, dulunya adalah Sekolah Dasar Belanda atau EUROPESE LAGERE SCHOOL / ELS (sekitar tahun 1941-1944-an). Sekitar tahun 1944 hingga tahun 1947, SD Belanda (ELS) sudah beralih menjadi SMP Negeri. Dimasa tersebut, SMP Negeri memiliki 4 (empat) kelas, yakni kelas I, kelas II, kelas III, dan kelas IV (yang sekarang hanya kelas I, II, dan III SMP)."
        //             }
        //         },
        //         {
        //             "type": "Feature",
        //             "geometry": {
        //                 "coordinates": [109.00513511650888, -7.723639208001302],
        //                 "type": "Point"
        //             },
        //             "properties": {
        //                 "locationId": "20300553",
        //                 "title": "SMP NEGERI 2 CILACAP",
        //                 "image": "https://www.google.com/maps/place/SMP+Negeri+2+Cilacap/@-7.7236476,109.0055752,3a,75y,90t/data=!3m8!1e2!3m6!1sT4-UBrLOzREnjZyQHce-d5RH0O67YHTxbb3CwuuXDM9fBhuEg-XBT17bEyYCEScA!2e9!3e27!6s%2F%2Flh3.googleusercontent.com%2FT4-UBrLOzREnjZyQHce-d5RH0O67YHTxbb3CwuuXDM9fBhuEg-XBT17bEyYCEScA%3Dw114-h86-k-no!7i3264!8i2448!4m7!3m6!1s0x2e656d4ad9357e43:0x4ffb3759c3c1ce5b!8m2!3d-7.723629!4d109.005547!10e5!16s%2Fg%2F1hm456_8m?entry=ttu&g_ep=EgoyMDI1MDIwNS4xIKXMDSoASAFQAw%3D%3D",
        //                 "description": "SMP Negeri 2 Cilacap yang beralamat di Jalan D.I. Panjaitan 37 Cilacap, didirikan tanggal 23 Januari 1961 merupakan Sekolah Standar Nasional Formal Mandiri sejak tanggal 3 September 2008."                        
        //             }
        //         }
        //     ]
        // };

        const loadLocations = (geoJson) => {
            geoJson.features.forEach((location) => {
                const {geometry, properties} = location
                const {iconSize, locationId, title, image, description} = properties

                let markerElement = document.createElement('div')
                markerElement.className = 'marker' + locationId
                markerElement.id = locationId
                markerElement.style.backgroundImage = 'url(https://th.bing.com/th/id/R.63faf74542220af5561843bd2180b7a0?rik=1sODl56oHkFX8A&riu=http%3a%2f%2fwww.pngall.com%2fwp-content%2fuploads%2f2018%2f04%2fSchool-PNG-Image-HD.png&ehk=E8wN4Mlq6mG9dKCL%2fRfxK08QccBjiw6aspKN1Tj3%2f4A%3d&risl=&pid=ImgRaw&r=0)'
                markerElement.style.backgroundSize = 'cover'
                markerElement.style.width = '50px'
                markerElement.style.height = '50px'

                const imageStorage = '{{ asset("/storage/public") }}' + '/' + image

                const content = `
                    <div style="overflow-y, auto;max-height:400px, width:100%">
                        <table class="table table-sm mt-2">
                            <tbody>
                                <tr>
                                    <td>Title</td>
                                    <td>${title}</td>
                                </tr>
                                <tr>
                                    <td>Picture</td>
                                    <td><img src="${imageStorage}" loading="lazy" class="img-fluid"></td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>${description}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>`

                markerElement.addEventListener('livewire:click', (e) => {
                    const locationId = e.toElement.id
                    @this.findLocationById(locationId)
                })

                const popUp = new mapboxgl.Popup({
                    offset:25
                }).setHTML(content).setMaxWidth("400px")

                new mapboxgl.Marker(markerElement)
                .setLngLat(geometry.coordinates)
                .setPopup(popUp)
                .addTo(map)
            })
        }

        loadLocations({!! $geoJson !!})

        window.addEventListener('locationAdded', (e) => {
            loadLocations(JSON.parse(e.detail))
        })

        window.addEventListener('updateLocation', (e) => {
            loadLocations(JSON.parse(e.detail))
            $('.mapboxgl-popup').remove()
        })

        window.addEventListener('deleteLocation', (e) => {
            $('.marker' + e.detail).remove()
            $('.mapboxgl-popup').remove()
        })


        map.addControl(new mapboxgl.NavigationControl())

        map.on('click', (e) => {
                const longitude = e.lngLat.lng
                const latitude = e.lngLat.lat

                @this.long = longitude
                @this.lat = latitude
            })
        
</script>
@endpush
