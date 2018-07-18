import {Component, Inject, OnInit} from '@angular/core';
import {PhotoInfo} from "../../api";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material";

@Component({
    selector: 'app-preview',
    templateUrl: './preview.component.html',
    styleUrls: ['./preview.component.css']
})

export class PreviewComponent implements OnInit {

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
