import {Component, Input, OnInit} from '@angular/core';
import {PhotoInfo, PhotoService, PublishPhotoRequest} from "../../api";
import {PublishPhotoRequestObject} from "../model/publishPhotoRequest";
import {isBoolean, isString, isUndefined} from "util";
import {MatDialog} from "@angular/material";
import {PreviewComponent} from "../preview/preview.component";

@Component({
    selector: 'app-item',
    templateUrl: './item.component.html',
    styleUrls: ['./item.component.css']
})
export class ItemComponent implements OnInit {
    @Input() photo: PhotoInfo;

    get published(): boolean {
        return this.photo.published;
    }

    set published(value: boolean) {
        let request: PublishPhotoRequest = new PublishPhotoRequestObject(this.photo.id, value);
        this.photoService.publishPhoto(request).subscribe(
            response => this.photo.published = value,
            response => this.photo.published = !value
        );
    }


    constructor(private photoService: PhotoService, private dialog: MatDialog) {
    }

    ngOnInit() {
    }

    openDialog() {
        let dialogRef = this.dialog.open(PreviewComponent, {
            width: '940px',
            data: this.photo
        });
    }

    public updatePhotoState(published: boolean) {
        let request: PublishPhotoRequest = new PublishPhotoRequestObject(this.photo.id, published);
        this.photoService.publishPhoto(request).subscribe(
            response => this.photo.published = published,
            response => this.photo.published = !published
        );
    }
}
