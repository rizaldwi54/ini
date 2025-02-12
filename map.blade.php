
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Mapbox
                </div>
                <div class="card-body">
                    <div wire:ignore id='map' style='width: 50%; height: 75vh;'></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Form
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveLocation">
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
                            @error('description')<small class="text-danger">{{ $message }}</small>@enderror
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
                        </div
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark text-white btn-block">Submit Location</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
