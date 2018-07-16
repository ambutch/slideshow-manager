import {Component, Input, OnInit} from '@angular/core';
import {PhotoInfo, PhotoService, PublishPhotoRequest} from "../../api";
import {PublishPhotoRequestObject} from "../list/publishPhotoRequest";
import {isBoolean, isString, isUndefined} from "util";

@Component({
    selector: 'app-item',
    templateUrl: './item.component.html',
    styleUrls: ['./item.component.css']
})
export class ItemComponent implements OnInit {

    @Input() photo: PhotoInfo;

    constructor(private photoService: PhotoService) {
    }

    ngOnInit() {
    }

    onStateChanged(event) {
        if(!isUndefined(event.event)){
            event.event.stopPropagation();
            if(isBoolean(event.value)) {
                this.updatePhotoState(event.value);
            }
        }
    }

    private updatePhotoState(published: boolean) {
        let request: PublishPhotoRequest = new PublishPhotoRequestObject(this.photo.id, published);
        this.photoService.publishPhoto(request).subscribe(
            response => this.photo.published = published,
            response => this.photo.published = !published
        );
    }
}
