    const canvas = document.getElementById('fireworksCanvas');
    const ctx = canvas.getContext('2d');
    let fireworks = [];


    canvas.width = document.body.scrollWidth;
    canvas.height = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);


    window.addEventListener('resize', () => {
      canvas.width = document.body.scrollWidth;
      canvas.height = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
    });

    class Particle {
      constructor(x, y, color, velocityX, velocityY) {
        this.x = x;
        this.y = y;
        this.color = color;
        this.velocityX = velocityX;
        this.velocityY = velocityY;
        this.radius = 2.5;
        this.opacity = 1;
      }

      update() {
        this.x += this.velocityX;
        this.y += this.velocityY;
        this.velocityY += 0.1;
        this.opacity -= 0.01;
      }

      draw(ctx) {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.globalAlpha = this.opacity;
        ctx.shadowBlur = 0;
        ctx.shadowColor = this.color;
        ctx.fill();
      }
    }

    class Firework {
      constructor(x, y) {
        this.x = x;
        this.y = y;
        this.particles = [];
        for (let i = 0; i < 50; i++) {
          const color = `hsl(${Math.random() * 360}, 100%, 50%)`;
          const velocityX = (Math.random() - 0.5) * 6;
          const velocityY = Math.random() * -15;
          this.particles.push(new Particle(x, y, color, velocityX, velocityY));
        }
      }

      update() {
        this.particles.forEach(particle => particle.update());
      }

      draw(ctx) {
        this.particles.forEach(particle => particle.draw(ctx));
      }
    }

    function animate() {
      ctx.fillStyle = 'rgba(0, 0, 0, 0.1)';
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      fireworks.forEach((firework, index) => {
        if (firework.particles[0].opacity <= 0) {
          fireworks.splice(index, 1);
        } else {
          firework.update();
          firework.draw(ctx);
        }
      });

      requestAnimationFrame(animate);
      
    }

    a=setInterval(function(){
        fireworks.push(new Firework((Math.random())*canvas.width, (Math.random())*canvas.height));
    },600)

    canvas.addEventListener('click', (event) => {
      const x = event.clientX;
      const y = event.clientY;
      fireworks.push(new Firework(x, y));
    });


    animate();