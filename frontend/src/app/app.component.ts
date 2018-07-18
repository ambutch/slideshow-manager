import {Component} from '@angular/core';
import {CommandService} from "../api";
import {MatButton} from "@angular/material";

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.css']
})
export class AppComponent {
    title = 'Slideshow manager';
    busy: boolean = false;


    constructor(private service: CommandService) {
    }

    public update() {
        this.busy = true;
        this.service.update().subscribe(null, null, () => {this.busy = false} );
    }
}
