import {Injector} from "@angular/core";
import {BASE_PATH} from "../api";
import {environment} from "../environments/environment";

Injector.create([{provide: BASE_PATH, useValue: environment.apiUrl}]);

