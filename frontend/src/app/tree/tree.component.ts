import {Component, OnInit} from '@angular/core';
import {DirectoryService, DirectoryTreeItem, ListDirectoryTreeResponse} from "../../api";
import {isUndefined} from "util";

@Component({
    selector: 'app-tree',
    templateUrl: './tree.component.html',
    styleUrls: ['./tree.component.css'],
    providers: [DirectoryService]
})
export class TreeComponent implements OnInit {
    public treeItems: DirectoryTreeItem[] = [];
    public currentItem: DirectoryTreeItem;

    constructor(private service: DirectoryService) {
        this.service.listDirectoryTree().subscribe(response => this.onDataLoad(response));
    }

    onDataLoad(response: ListDirectoryTreeResponse) {
        this.treeItems[0] = response.root;
        this.currentItem = this.treeItems[0];
    }

    selectItem(e) {
        if(!isUndefined(e.itemData)) {
            this.currentItem = e.itemData;
        }
    }

    ngOnInit() {

    }

}
