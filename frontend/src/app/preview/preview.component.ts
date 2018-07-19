import {Component, Inject, OnInit} from '@angular/core';
import {PhotoInfo} from "../../api";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";
import {environment} from "../../environments/environment";

@Component({
    selector: 'app-preview',
    templateUrl: './preview.component.html',
    styleUrls: ['./preview.component.css']
})

export class PreviewComponent implements OnInit {

    public baseUrl: string = environment.apiUrl;

    constructor(
        public dialogRef: MatDialogRef<PreviewComponent>,
        @Inject(MAT_DIALOG_DATA) public data: PhotoInfo) {
    }

    ngOnInit() {
    }

    onCloseConfirm() {
        this.dialogRef.close();
    }

    onCloseCancel() {
        this.dialogRef.close();
    }
}
