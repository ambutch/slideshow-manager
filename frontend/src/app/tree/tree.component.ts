import {Component, OnInit} from '@angular/core';
import {DirectoryService, DirectoryTreeItem, ListDirectoryTreeResponse} from "../../api";
import {isUndefined} from "util";
import {NestedTreeControl} from '@angular/cdk/tree';
import {MatTreeNestedDataSource} from '@angular/material/tree';

@Component({
    selector: 'app-tree',
    templateUrl: './tree.component.html',
    styleUrls: ['./tree.component.css'],
    providers: [DirectoryService]
})
export class TreeComponent implements OnInit {
    public currentItem: DirectoryTreeItem;

    public nestedTreeControl: NestedTreeControl<DirectoryTreeItem>;
    public nestedDataSource: MatTreeNestedDataSource<DirectoryTreeItem>;

    constructor(private service: DirectoryService) {
        this.nestedTreeControl = new NestedTreeControl<DirectoryTreeItem>(this._getChildren);
        this.nestedDataSource = new MatTreeNestedDataSource();
        this.service.listDirectoryTree().subscribe(response => this.onDataLoad(response));
    }

    onDataLoad(response: ListDirectoryTreeResponse) {
        this.nestedDataSource.data = response.root.children;
        this.currentItem = this.nestedDataSource.data[0];
    }

    selectItem(directory: DirectoryTreeItem) {
        this.currentItem = directory;
    }

    hasNestedChild = (_: number, nodeData: DirectoryTreeItem) => nodeData.children.length > 0;

    ngOnInit() {

    }

    private _getChildren = (node: DirectoryTreeItem) => node.children;

}
