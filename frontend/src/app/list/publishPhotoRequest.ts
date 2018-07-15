/**
 * Slideshow manager
 * API for Slideshow manager SPA
 *
 * OpenAPI spec version: 1.0.0
 *
 *
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen.git
 * Do not edit the class manually.
 */
import {PublishPhotoRequest} from "../../api";


export class PublishPhotoRequestObject implements PublishPhotoRequest {
    photoId: string;
    published: boolean;

    constructor(photoId: string, published: boolean) {
        this.photoId = photoId;
        this.published = published;
    }
}
