import {Component, Input, OnInit} from '@angular/core';
import {DirectoryService, DirectoryTreeItem, ListDirectoryInfoResponse, PhotoInfo} from "../../api";
import {isObject, isString, isUndefined} from "util";

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
        if (!isUndefined(currentDirectory)) {
            this.changeDirectory(currentDirectory);
        }
    }

    constructor(private directoryService: DirectoryService) {
    }

    onDataLoad(response: ListDirectoryInfoResponse) {
        this.path = response.path;
        this.photos = response.photos;
    }

    onPhotoClick(event) {
        if (!isUndefined(event.itemData) && !isUndefined(event.itemData.dataField) && isObject(event.itemData.dataField)) {
            this.showPhotoPreview(event.itemData.dataField);
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

    private showPhotoPreview(photo: PhotoInfo) {
        this.popUpImageUrl = 'url(http://localhost:8000/image/preview/' + photo.id + ')';
        this.popUpTitle = photo.name;
        this.isPopupVisible = true;
    }

}
