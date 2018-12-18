let buildingData = [
  {buildingId: 0, Xi: 1, Yi: 0},
  {buildingId: 1, Xi: 2, Yi: 2},
  {buildingId: 2, Xi: 7, Yi: 2},
  {buildingId: 3, Xi: 9, Yi: 6}
]

window.Game = {
    tileColumnOffset: 100, // pixels
    tileRowOffset: 50, // pixels
  
    originX: 0, // offset from left
    originY: 0, // offset from top
  
    Xtiles: 0, // Number of tiles in X-dimension
    Ytiles: 0, // Number of tiles in Y-dimension

    selectedTileX: -1,
    selectedTileY: -1,

    buyModalOpen: false,
  
    context: undefined,
    canvas: undefined,
  
    tileImages: undefined,
    buildingImages: undefined,

    showCoordinates: true,
  
    load: function() {
      this.tileImages = new Array();
      this.buildingImages = new Array();
      let loadedImages = 0;
      let totalImages = GameDataObject.tiles.length + GameDataObject.building.length;
  
      // Load Tiles
      for(let i = 0; i < GameDataObject.tiles.length; i++) {
        this.tileImages[i] = new Image();

        this.tileImages[i].onload = () => {
          if(++loadedImages >= totalImages) {
            this.run();
          }
        };

        this.tileImages[i].src = GameDataObject.tiles[i];
      }

       // Load Buildings
       for(let i = 0; i < GameDataObject.building.length; i++) {
        this.buildingImages[i] = new Image();

        this.buildingImages[i].onload = () => {
          if(++loadedImages >= totalImages) {
            this.run();
          }
        };

        this.buildingImages[i].src = GameDataObject.building[i].img;
      }
  
    },
  
    run: function() {
      this.canvas = $('#isocanvas');
      this.context = this.canvas[0].getContext("2d");
  
      this.Xtiles = GameDataObject.map.length;
      this.Ytiles = GameDataObject.map[0].length;
  
      $(window).on('resize', () => {
        this.updateCanvasSize();
        this.redrawTiles();
        this.redrawBuildings()
      });

      $(window).on('mousemove', (e) => {
        e.pageX = e.pageX - this.tileColumnOffset / 2 - this.originX;
        e.pageY = e.pageY - this.tileRowOffset / 2 - this.originY;
        tileX = Math.round(e.pageX / this.tileColumnOffset - e.pageY / this.tileRowOffset);
        tileY = Math.round(e.pageX / this.tileColumnOffset + e.pageY / this.tileRowOffset);
   
        this.selectedTileX = tileX;
        this.selectedTileY = tileY;
        this.redrawTiles();
        this.redrawBuildings();
      });
  
      $(window).on('click', (e) => {
        if(this.selectedTileX > -1 
          && this.selectedTileY > -1 
          && GameDataObject.map[this.selectedTileX][this.selectedTileY] === 1
          && !this.buyModalOpen
        ){
            console.log(this.buyModalOpen)
            this.buyModalOpen = true
            EventBus.$emit('openBuyBuilding', {Xi: this.selectedTileX, Yi: this.selectedTileY});
          }

        //this.addBuilding()
        //this.showCoordinates = !this.showCoordinates;
        //this.redrawTiles();
      });
  
      this.updateCanvasSize();
      this.redrawTiles();
      this.redrawBuildings()
    },

    addBuilding: function(){
      if(this.selectedTileX > -1 
          && this.selectedTileY > -1 
          && GameDataObject.map[this.selectedTileX][this.selectedTileY] === 1
      ){
        buildingData.push({buildingId: 0, Xi: this.selectedTileX, Yi: this.selectedTileY});
        this.redrawBuildings();
      }
    },
  
    updateCanvasSize: function() {
      let width = $(window).width();
      let height = $(window).height();
  
      this.context.canvas.width  = width;
      this.context.canvas.height = height;
  
      this.originX = width / 2 - this.Xtiles * this.tileColumnOffset / 2;
      this.originY = height / 2;
    },
  
    redrawTiles: function() {
      this.context.canvas.width = this.context.canvas.width;
  
      for(let Xi = (this.Xtiles - 1); Xi >= 0; Xi--) {
        for(let Yi = 0; Yi < this.Ytiles; Yi++) {
          this.drawTile(Xi, Yi);
        }
      }

      this.drawDiamond(this.selectedTileX, this.selectedTileY, 'yellow');
    },

    redrawBuildings: function() {
      let buildings = _.orderBy(buildingData, ["Xi", "Yi"], ['desc']);
      buildings.forEach((item) => {
        this.drawBuilding(item.buildingId, item.Xi, item.Yi)
      })
    },

    drawBuilding: function(buildingIndex, Xi, Yi) {
      let offX = Xi * this.tileColumnOffset / 2 + Yi * this.tileColumnOffset / 2 + this.originX + GameDataObject.building[buildingIndex].offX;
      let offY = Yi * this.tileRowOffset / 2 - Xi * this.tileRowOffset / 2 + this.originY - GameDataObject.building[buildingIndex].offY;
  
      this.context.drawImage(this.buildingImages[buildingIndex], offX, offY);
    },
  
    drawTile: function(Xi, Yi) {
      let offX = Xi * this.tileColumnOffset / 2 + Yi * this.tileColumnOffset / 2 + this.originX;
      let offY = Yi * this.tileRowOffset / 2 - Xi * this.tileRowOffset / 2 + this.originY;
  
      let imageIndex = GameDataObject.map[Xi][Yi];
  
      this.context.drawImage(this.tileImages[imageIndex], offX, offY);
      
      if(this.showCoordinates) {
        this.context.fillStyle = 'orange';
        this.context.fillText(Xi + ", " + Yi, offX + this.tileColumnOffset/2 - 9, offY + this.tileRowOffset/2 + 3);
      }
    },
  
    drawLine: function(x1, y1, x2, y2, color) {
      color = typeof color !== 'undefined' ? color : 'white';
      this.context.strokeStyle = color;
      this.context.beginPath();
      this.context.lineWidth = 1;
      this.context.moveTo(x1, y1);
      this.context.lineTo(x2, y2);
      this.context.stroke();
    },

    drawDiamond: function(Xi, Yi, color) {
      if(this.isCursorOnMap() && GameDataObject.map[this.selectedTileX][this.selectedTileY] === 1) {
        var offX = Xi * this.tileColumnOffset / 2 + Yi * this.tileColumnOffset / 2 + this.originX;
        var offY = Yi * this.tileRowOffset / 2 - Xi * this.tileRowOffset / 2 + this.originY;
  
        this.drawLine(offX, offY + this.tileRowOffset / 2, offX + this.tileColumnOffset / 2, offY, color);
        this.drawLine(offX + this.tileColumnOffset / 2, offY, offX + this.tileColumnOffset, offY + this.tileRowOffset / 2, color);
        this.drawLine(offX + this.tileColumnOffset, offY + this.tileRowOffset / 2, offX + this.tileColumnOffset / 2, offY + this.tileRowOffset, color);
        this.drawLine(offX + this.tileColumnOffset / 2, offY + this.tileRowOffset, offX, offY + this.tileRowOffset / 2, color);
      }
    },

    isCursorOnMap: function() {
      return (this.selectedTileX >= 0 && this.selectedTileX < this.Xtiles &&
              this.selectedTileY >= 0 && this.selectedTileY < this.Ytiles);
    },
  };
  
  