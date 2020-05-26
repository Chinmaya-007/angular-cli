import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BiddinghistoryComponent } from './biddinghistory.component';

describe('BiddinghistoryComponent', () => {
  let component: BiddinghistoryComponent;
  let fixture: ComponentFixture<BiddinghistoryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BiddinghistoryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BiddinghistoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
