import {Component, Input, OnInit} from '@angular/core';
import {
    DirectoryService,
    DirectoryTreeItem,
    ListDirectoryInfoResponse,
    PhotoInfo,
    PhotoService,
    PublishPhotoRequest
} from "../../api";
import {PublishPhotoRequestObject} from "./publishPhotoRequest";
import {isBoolean, isString, isUndefined} from "util";

@Component({
    selector: 'app-list',
    templateUrl: './list.component.html',
    styleUrls: ['./list.component.css']
})
export class ListComponent implements OnInit {

    private directory: DirectoryTreeItem;
    public path: string;
    public photos: PhotoInfo[] = [];
    public popUpTitle: string = 'Photo';
    public popUpImageUrl: string = '';
    public isPopupVisible: boolean = false;

    //

    @Input() set currentDirectory(currentDirectory: DirectoryTreeItem) {
        if(!isUndefined(currentDirectory)) {
            this.changeDirectory(currentDirectory);
        }
    }

    constructor(private directoryService: DirectoryService, private photoService: PhotoService) {
    }

    onDataLoad(response: ListDirectoryInfoResponse) {
        this.path = response.path;
        this.photos = response.photos;
    }

    onPhotoClick(event) {
        if(!isUndefined(event.itemData) && !isUndefined(event.itemData.dataField) && isString(event.itemData.dataField)) {
            this.showPhotoPreview(event.itemData.dataField);
        }
    }

    onStateChanged(event) {
        if(!isUndefined(event.element) && isString(event.element.id) && isBoolean(event.value)) {
            this.updatePhotoState(event.element.id, event.value);
        }
    }

    ngOnInit() {
    }

    private changeDirectory(currentDirectory: DirectoryTreeItem) {
        this.directory = currentDirectory;
        this.updateList();
    }

    private updateList() {
        this.directoryService.listDirectory(this.directory.id).subscribe(response => this.onDataLoad(response));
    }

    private updatePhotoState(photoId: string, published: boolean) {
        let request: PublishPhotoRequest = new PublishPhotoRequestObject(photoId, published);
        this.photoService.publishPhoto(request).subscribe(response => this.updateList());
    }

    private showPhotoPreview(id: string){
        this.popUpImageUrl = 'url(http://localhost:8000/image/preview/' + id + ')';
        this.isPopupVisible = true;
    }

}
